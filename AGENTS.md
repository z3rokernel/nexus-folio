# AGENTS.md — NEXUS-FOLIO

## Mission
Personal portfolio that feels like a sci-fi film trailer. Showcase projects with immersive motion while staying fast and accessible.

## Stack (fixed)
- **PHP 8.2+, CodeIgniter 4.5+** (appstarter via Composer)
- **DB:** SQLite for dev (`writable/db.sqlite`), MySQL for prod — all via migrations/seeders
- **CSS:** Tailwind CSS v4 (CLI) + hand-written CSS variables for theme tokens
- **JS (vanilla ESM):** GSAP 3 + plugins, Lenis, Three.js, Barba.js, (optional) Howler for UI sounds
- **Tooling:** npm scripts, PHPUnit, PHP-CS-Fixer (optional), GitHub Actions

## Folder conventions
```
app/Controllers/   Pages.php, Projects.php, Contact.php, Api/GitHub.php
app/Models/        ProjectModel.php, SkillModel.php, ExperienceModel.php, MessageModel.php
app/Views/         layouts/, pages/, partials/, components/
app/Database/      Migrations/, Seeds/
public/assets/     css/, js/ (modules/, shaders/), img/, video/, fonts/
resources/css/     app.css (Tailwind entry)
docs/              specs (source of truth)
```

## Non-negotiables
1. Specs in `docs/` are the source of truth. If you deviate, document why in `docs/DECISIONS.md`.
2. Every animation has a **reduced-motion fallback**.
3. Everything must work **without JS** at a basic readable level (progressive enhancement; content is server-rendered).
4. Never hardcode secrets. Use `.env`. Commit `.env.example` only.
5. Escape all output (`esc()`), validate all input, CSRF + honeypot + throttle on forms.
6. Keep JS modular: one file per feature in `public/assets/js/modules/`, bootstrapped from `main.js`.
7. After Barba page transitions, **destroy and re-init** all per-page ScrollTriggers/listeners (no leaks).
8. Run `php spark routes`, `npm run build`, and `vendor/bin/phpunit` before every commit.
9. Commit messages: Conventional Commits (`feat:`, `fix:`, `chore:`, `docs:`, `perf:`).

## Definition of Done (per feature)
- Matches spec + acceptance criteria
- Verified in browser (screenshot artifact), desktop 1440 + mobile 390
- 60fps on mid-range laptop (no long tasks > 50ms during scroll)
- No console errors; Lighthouse Perf ≥ 85, A11y ≥ 95
