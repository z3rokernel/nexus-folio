# /bootstrap — Scaffold the project

1. Verify tools: `php -v` (>=8.2), `composer -V`, `node -v` (>=20), `git --version`. Report missing ones and stop.
2. If the folder has no `composer.json`: scaffold CodeIgniter 4 with `composer create-project codeigniter4/appstarter` into a temp dir, then move files into the root, preserving `docs/`, `.agent/`, `AGENTS.md`, `PROMPT.md`, `README.md`.
3. `cp env .env`; set `CI_ENVIRONMENT = development`, `app.baseURL = 'http://localhost:8080/'`, SQLite config (`database.default.DBDriver = SQLite3`, `database.default.database = db.sqlite`).
4. `npm init -y`; install dev deps `tailwindcss @tailwindcss/cli`; add scripts:
   - `"dev:css": "tailwindcss -i resources/css/app.css -o public/assets/css/app.css --watch"`
   - `"build": "tailwindcss -i resources/css/app.css -o public/assets/css/app.css --minify"`
5. Create the folder structure from `AGENTS.md`. Extend `.gitignore`: `node_modules/`, `.env`, `writable/db.sqlite`.
6. Create the base layout (`layouts/main.php`) with pinned CDN scripts from `docs/03` and theme tokens from `docs/01`.
7. Run `php spark serve` + `npm run dev:css`, open the browser, screenshot the hello page as an artifact.
8. Commit: `chore: scaffold CodeIgniter 4 + Tailwind + motion stack`.
