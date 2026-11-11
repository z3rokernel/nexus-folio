# MASTER PROMPT — paste into Antigravity Agent Manager (Planning mode)

You are a senior creative developer + art director. Build my personal portfolio website, **NEXUS-FOLIO**, in a style comparable to cutting-edge AI-product sites like Higgsfield: dark cinematic void, acid-lime accents, WebGL shader backgrounds, buttery smooth scroll, kinetic typography, magnetic/cursor-aware interactions and page transitions that feel like a film.

## Read first (in this order)
1. `AGENTS.md`
2. `.agent/rules/*`
3. `docs/01-VISION-DESIGN-SYSTEM.md` → `docs/08-PERFORMANCE-A11Y-QA.md`

## Hard constraints
- Backend: **CodeIgniter 4** (PHP 8.2+), server-rendered views, MySQL/SQLite via migrations + seeders.
- Frontend: Tailwind CSS v4 (CLI build) + **GSAP 3 (all plugins incl. ScrollTrigger, SplitText, Flip, ScrambleText, CustomEase)** + **Lenis** + **Three.js** (custom GLSL shaders) + **Barba.js** page transitions. Load libs via pinned CDN URLs (see `docs/03-ANIMATION-SPEC.md`).
- No React/Vue/Next. Vanilla ES modules only.
- Must respect `prefers-reduced-motion`, be keyboard accessible, and hit performance budgets in `docs/08`.
- Git: initialize repo, use Conventional Commits, push to GitHub following `docs/06-GITHUB-DEPLOY.md`. **Never commit `.env`.**

## Process
1. **Plan first.** Produce an Implementation Plan artifact + task list based on `docs/07-ROADMAP-CHECKLIST.md`. Wait for my approval.
2. Execute phase by phase. After each phase: run the app, take **browser screenshots / a recording** as artifacts, and verify against the spec's acceptance criteria.
3. Commit after each phase with a conventional commit message.
4. At the end, run `/ship-to-github` and give me: repo URL, run instructions, and a list of what to customize (my content, images, videos).

## Surprise me
Implement the "Easter eggs & wow features" in `docs/03-ANIMATION-SPEC.md` §10 (command palette, AI-style "generating" preloader, Konami mode, live GitHub stats, etc.).

Start now with the Implementation Plan.
