# Rule: CodeIgniter 4 backend (always on)
- Controllers thin, models handle queries, views dumb. No SQL in controllers/views.
- Use Migrations + Seeders only. No manual DB edits.
- Validation via `$this->validate()` or `app/Config/Validation.php`.
- Use `esc()` in views; `csrf_field()` in forms; enable `honeypot` + a cache-based `throttle` filter (5 req/min) on `POST /contact`.
- Route everything in `app/Config/Routes.php` with named routes (`'as' => 'project.show'`).
- Barba requests: always return full HTML (Barba extracts the `data-barba="container"`); keep it simple.
- Cache external calls (GitHub stats) with `cache()->remember()` TTL 1h.
- `CI_ENVIRONMENT=development` locally, `production` in prod. No debug toolbar in prod.
- Security headers via a custom filter (CSP allowing the pinned CDNs, X-Frame-Options, Referrer-Policy, Permissions-Policy).
