FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY app ./app
RUN npm run build

FROM php:8.3-apache
RUN apt-get update && apt-get install -y libicu-dev libzip-dev libsqlite3-dev unzip \
 && docker-php-ext-install intl pdo_mysql pdo_sqlite zip && a2enmod rewrite headers
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/assets/css/app.css public/assets/css/app.css
RUN composer install --no-dev --optimize-autoloader && chown -R www-data:www-data writable 2>/dev/null; chmod -R 775 writable

