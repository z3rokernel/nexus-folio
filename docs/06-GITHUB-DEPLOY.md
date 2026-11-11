# 06 — GitHub, CI & Deployment

## Repo setup
- Name suggestion: `nexus-folio` (or `portfolio`). Public. License MIT.
- Branches: `main` (production, protected), `develop` (integration), `feat/*`.
- Conventional Commits: `feat(hero): liquid shader`, `fix(reel): pin jump on resize`, `perf: cap DPR`, `docs:`, `chore:`.

## `.gitignore` (append to CI4 default)
```
/node_modules
.env
/writable/db.sqlite
/writable/uploads/*
!/writable/uploads/.gitkeep
.DS_Store
.idea
.vscode
```
Keep `.env.example` committed (no secrets). Decide with the user whether `public/assets/css/app.css` is committed (needed for hosts without Node) — default: **built in CI/deploy**.

## Commands (manual path)
```bash
git init
git branch -M main
git add -A
git commit -m "feat: initial release of NEXUS-FOLIO"
# Option A — GitHub CLI
gh auth login
gh repo create nexus-folio --public --source=. --remote=origin --push
# Option B — manual: create empty repo on github.com, then
git remote add origin https://github.com/<user>/nexus-folio.git
git push -u origin main
git checkout -b develop && git push -u origin develop
```
If push is rejected for auth: use a **Personal Access Token** (repo scope) or `gh auth login` / SSH key. Never paste tokens into files.

## `.github/workflows/ci.yml`
```yaml
name: CI
on:
  push: { branches: [main, develop] }
  pull_request:
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.3', extensions: intl, mbstring, sqlite3, coverage: none }
      - uses: actions/setup-node@v4
        with: { node-version: 20, cache: npm }
      - run: composer install --no-interaction --prefer-dist
      - run: npm ci && npm run build
      - run: cp env .env && php spark migrate --all
      - run: vendor/bin/phpunit
```

## `README.md` (project) must include
Hero screenshot/GIF, feature list, stack badges, quick start (`composer install`, `npm i`, `cp env .env`, `php spark migrate`, `php spark db:seed DatabaseSeeder`, `php spark serve`, `npm run dev:css`), env vars table, folder map, license, "Customize your content" section.

## Deployment options
| Option | Notes |
|---|---|
| **VPS (Nginx + PHP-FPM)** | Best control; point root to `/public`; `CI_ENVIRONMENT=production`; HTTPS via Certbot |
| **Shared hosting (cPanel/OVH)** | Upload; set document root to `public/`; commit built CSS; use MySQL |
| **Render / Railway / Fly.io (Docker)** | Use Dockerfile below |
| **Coolify / Dokploy** | Self-hosted PaaS from the GitHub repo |

### Dockerfile
```dockerfile
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY app ./app
RUN npm run build

FROM php:8.3-apache
RUN apt-get update && apt-get install -y libicu-dev libzip-dev unzip \
 && docker-php-ext-install intl pdo_mysql zip && a2enmod rewrite headers
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/assets/css/app.css public/assets/css/app.css
RUN composer install --no-dev --optimize-autoloader && chown -R www-data:writable writable 2>/dev/null; chmod -R 775 writable
```
Production checklist: `CI_ENVIRONMENT=production`, `app.forceGlobalSecureRequests=true`, strong `encryption.key` (`php spark key:generate`), writable perms, gzip/brotli + long-cache headers for `/assets/*`, `php spark optimize`.
