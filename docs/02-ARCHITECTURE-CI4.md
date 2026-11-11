# 02 — CodeIgniter 4 Architecture

## Setup
```bash
composer create-project codeigniter4/appstarter portfolio
cd portfolio && cp env .env
php spark serve        # http://localhost:8080
```
`.env` essentials:
```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.DBDriver = SQLite3
database.default.database = db.sqlite
email.fromEmail = 'noreply@yourdomain.com'
email.SMTPHost = ''
GITHUB_USER = 'your-username'
GITHUB_TOKEN = ''           # optional, raises API rate limit
CONTACT_TO = 'you@domain.com'
```

## Routes (`app/Config/Routes.php`)
```php
$routes->get('/', 'Pages::home', ['as' => 'home']);
$routes->get('about', 'Pages::about', ['as' => 'about']);
$routes->get('work', 'Projects::index', ['as' => 'work']);
$routes->get('work/(:segment)', 'Projects::show/$1', ['as' => 'project.show']);
$routes->get('contact', 'Contact::index', ['as' => 'contact']);
$routes->post('contact', 'Contact::send', ['filter' => ['honeypot','throttle'], 'as' => 'contact.send']);
$routes->get('api/github', 'Api\GitHub::stats');
$routes->get('sitemap.xml', 'Pages::sitemap');
$routes->set404Override('App\Controllers\Pages::notFound');
```

## Controllers
- `Pages` — home (featured projects + skills + stats), about, notFound (stylish glitch 404), sitemap.
- `Projects` — index (all, filter by tag via query `?tag=ai`), show (slug; prev/next project).
- `Contact` — validate (name, email, message ≥ 20 chars), store in `messages` table, send email via CI4 `Email` service, respond JSON when `Accept: application/json` (AJAX) else redirect with flash.
- `Api\GitHub` — fetch user + contributions summary (GraphQL if token, else public events), cache 1h, return JSON.

## Models & tables (migrations)
| Table | Columns |
|---|---|
| `projects` | id, slug (unique), title, subtitle, year, role, client, summary, body (longtext), cover_image, cover_video, accent, tags (JSON), stack (JSON), live_url, repo_url, featured (bool), sort_order, published (bool), created_at, updated_at |
| `project_media` | id, project_id, type (image/video), path, caption, sort_order |
| `skills` | id, name, category, level (0-100), icon, sort_order |
| `experiences` | id, company, role, start, end, description, sort_order |
| `messages` | id, name, email, message, ip, user_agent, created_at |

Use `$useTimestamps = true`, `$allowedFields`, and `$returnType = 'array'`. Cast JSON fields in a helper or via custom Entity (`app/Entities/Project.php` with `$casts = ['tags'=>'json-array','stack'=>'json-array']`).

## Views
```
app/Views/
├── layouts/main.php        # <head>, importmap, CDNs, barba wrapper, persistent canvas, HUD, cursor
├── pages/{home,about,work,project,contact,404}.php
├── partials/{nav,footer,hud,preloader,menu-overlay,command-palette}.php
└── components/{project-card,section-title,skill-chip,button,stat}.php
```
Barba markup in layout:
```html
<body data-barba="wrapper">
  <?= view('partials/preloader') ?> <?= view('partials/hud') ?> <canvas id="gl-bg"></canvas>
  <main data-barba="container" data-barba-namespace="<?= $namespace ?? 'home' ?>">
    <?= $this->renderSection('content') ?>
  </main>
</body>
```
Use view layouts: `<?= $this->extend('layouts/main') ?>` / `<?= $this->section('content') ?>`.

## Filters (`app/Config/Filters.php`)
- Built-in `honeypot`, `csrf` (global for POST), `secureheaders`.
- Custom `Throttle` filter (cache-based, key `throttle:{ip}`, 5/min) → 429 JSON.
- Custom `SecurityHeaders` for CSP — allow `cdn.jsdelivr.net`, `unpkg.com`, `fonts.googleapis.com`, `fonts.gstatic.com`, `'self'`, `blob:` for workers/video, `data:` for images.

## SEO
Per-page `$meta` array (title, description, og:image, canonical, JSON-LD `Person` + `CreativeWork`). Generate `sitemap.xml` and `robots.txt`.

## Seeds
`DatabaseSeeder` calls `ProjectSeeder`, `SkillSeeder`, `ExperienceSeeder` — populated from `docs/05-DATA-CONTENT.md`.

## Tests (PHPUnit)
Feature tests: `/` returns 200, `/work/{slug}` 200 and `/work/nope` 404, `POST /contact` validates + honeypot blocks bots + throttle returns 429 on the 6th call.
