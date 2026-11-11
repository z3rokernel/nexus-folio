# /ship-to-github — Publish the repo

1. Pre-flight: `npm run build`, `vendor/bin/phpunit`, `php spark routes`. Stop on failure.
2. Security: `.env` must NOT be tracked (`git ls-files | grep -E '^\.env$'` must be empty). Grep for secrets (`api_key`, `secret`, `password`) outside `vendor/`, `node_modules/`, `.git/`.
3. Ensure these exist: project `README.md`, `LICENSE` (MIT), `.env.example`, `.github/workflows/ci.yml` (templates in `docs/06-GITHUB-DEPLOY.md`).
4. `git init` (if needed) → `git branch -M main` → `git add -A` → `git commit -m "feat: initial release of NEXUS-FOLIO"`.
5. Create the remote:
   - If `gh` is installed and authenticated: `gh repo create <repo-name> --public --source=. --remote=origin --push --description "Cinematic CodeIgniter 4 portfolio"`.
   - Otherwise ask me for the repo URL, then `git remote add origin <url>` and `git push -u origin main`.
6. Create a `develop` branch and push it.
7. Confirm CI is green (`gh run watch` if available).
8. Report: repo URL, clone-and-run steps, deployment options.
