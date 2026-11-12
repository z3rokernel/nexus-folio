# ⚡ Mostepha Amine Bdeira — mabdeira.dev

![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter 4.7](https://img.shields.io/badge/CodeIgniter-4.7-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![Three.js WebGL](https://img.shields.io/badge/Three.js-r170_GLSL-000000?style=for-the-badge&logo=threedotjs&logoColor=D4FF1F)
![GSAP 3.13](https://img.shields.io/badge/GSAP-3.13_All_Plugins-88CE02?style=for-the-badge&logo=greensock&logoColor=black)
![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4.3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-D4FF1F?style=for-the-badge)

> **mabdeira.dev** is the official engineering portfolio of **Mostepha Amine Bdeira** (Full-Stack Web Developer & QA Tester based in Lyon, France). Built on a server-rendered **CodeIgniter 4** backend with custom **Three.js GLSL shaders**, **GSAP 3.13 + ScrollTrigger + Flip + SplitText + ScrambleText**, **Lenis** smooth scroll, **Barba.js** page transitions, and interactive developer telemetry.

---

## ✨ Signature Features

- **🎬 AI "Generating…" Preloader:** Full-screen black boot sequence with `ScrambleText`, non-linear `0→100%` counter, a live pixelation-to-sharpness resolution shader (`64×64 → 1×1`), and a 2-panel clip-path curtain reveal (`< 3.2s`, plays once per session).
- **🌊 Liquid FBM Shader Hero + 3D Chrome Icosahedron:** Domain-warped fractional Brownian motion fragment shader reacting to pointer velocity, scroll depth, and live theme switches (`Acid Lime #D4FF1F`, `Plasma Violet #7B5CFF`, `Cyber Cyan #2DE2E6`).
- **🎞️ Pinned Horizontal Project Reel (`/`) & Flip Archive (`/work`):** Scroll-scrubbed horizontal scene reel on desktop with keyboard arrow navigation (`←`/`→`), hover chromatic displacement, and GSAP Flip category filtering + Grid/List view toggle.
- **🧪 Matter.js 2D Skills Physics Playground:** Rigid-body skill chips that drop from above, collide, and can be dragged and thrown with the cursor (`IMPULSE GRAVITY` launcher included) + accessible static tag cloud.
- **📊 Live GitHub Contribution Heat-Grid (`/api/github`):** Server-cached (1h TTL) 52-week contribution matrix rendered on `<canvas>` with a cursor-proximity wave glow.
- **⌨️ Command Palette (`Ctrl/⌘ + K`):** Fuzzy search modal across all scenes, case studies, and studio actions (*Copy Email*, *Download CV*, *Cycle Theme*, *Toggle Studio Audio*, *Toggle Reduced Motion*, *Trigger Konami Overdrive*).
- **👾 Konami Code Glitch Overdrive (`↑↑↓↓←→←→BA`):** Full-viewport RGB chromatic aberration, CRT scanlines, and `⚠ INTRUDER DETECTED` HUD alert.
- **🖥️ Interactive CLI Terminal (`/about`):** Type live commands (`help`, `whoami`, `skills`, `projects`, `contact`, `theme plasma`, `motion`, `cv`, `clear`).
- **🛡️ Hardened Security & Progressive Enhancement:** Full server-rendered HTML works without JS; `POST /contact` protected by CSRF, Honeypot, and a custom cache-backed `ThrottleFilter` (`5 req/min` → HTTP `429`), plus strict `Content-Security-Policy` headers.

---

## 🚀 Quick Start (Local Development)

### Prerequisites
- **PHP 8.2+** with `intl`, `mbstring`, `sqlite3`, `curl` enabled
- **Composer 2+**
- **Node.js 20+** & **npm**

### Installation & Run
```bash
# 1. Install PHP & Node dependencies
composer install
npm install

# 2. Configure environment & SQLite database
cp .env.example .env
php spark migrate --all
php spark db:seed DatabaseSeeder

# 3. Build Tailwind CSS v4 bundle (or watch with `npm run dev:css`)
npm run build

# 4. Launch the development server at http://localhost:8080
php spark serve
```

### Run Automated Tests & Route Check
```bash
php spark routes
vendor/bin/phpunit
```

---

## ⚙️ Environment Variables (`.env`)

| Variable | Default | Purpose |
|---|---|---|
| `CI_ENVIRONMENT` | `development` | Set to `production` on live server |
| `app.baseURL` | `'http://localhost:8080/'` | Canonical base URL |
| `database.default.DBDriver` | `SQLite3` | `SQLite3` for local dev, `MySQLi` for production |
| `database.default.database` | `db.sqlite` | Stored in `writable/db.sqlite` |
| `PORTFOLIO_NAME` | `'Mostepha Amine Bdeira'` | Developer name displayed across Hero, About, SEO & Footer |
| `PORTFOLIO_HANDLE` | `'MABDEIRA.DEV'` | Brand mark & header handle |
| `PORTFOLIO_CITY` | `'Lyon, France'` | Displayed in top HUD telemetry bar |
| `PORTFOLIO_TIMEZONE` | `'Europe/Paris'` | Timezone for live HUD clock |
| `PORTFOLIO_EMAIL` | `'contact@mabdeira.dev'` | Direct contact & click-to-copy email |
| `PORTFOLIO_PHONE` | `'+33 6 15 21 88 14'` | Direct phone number on Contact & About pages |
| `GITHUB_USER` | `'z3rokernel'` | Username queried by `/api/github` |
| `CONTACT_TO` | `'contact@mabdeira.dev'` | Recipient for `/contact` email dispatches |

---

## 🗂️ Project Architecture

```text
├── app/
│   ├── Config/          Routes.php, Filters.php, Database.php, Security.php
│   ├── Controllers/     Pages.php, Projects.php, Contact.php, Api/GitHub.php
│   ├── Database/        Migrations/ (5 tables), Seeds/ (Project, Skill, Experience)
│   ├── Filters/         ThrottleFilter.php (5/min), SecurityHeadersFilter.php (CSP)
│   ├── Models/          ProjectModel.php, SkillModel.php, ExperienceModel.php, MessageModel.php
│   └── Views/           layouts/main.php, pages/*, partials/*, components/*
├── public/
│   ├── assets/
│   │   ├── css/         app.css (compiled Tailwind v4 + theme tokens)
│   │   ├── img/         projects/<slug>/{cover,detail-01,detail-02}.svg, portrait.svg
│   │   └── js/          main.js, core/*, modules/*, shaders/*.glsl
│   ├── cv.pdf           Downloadable resume
│   └── robots.txt
├── resources/css/       app.css (Tailwind CSS v4 entry & design system tokens)
├── tests/feature/       PortfolioTest.php (PHPUnit feature & security test suite)
├── docs/                01..08 specifications, ASSETS-TODO.md, DECISIONS.md
├── Dockerfile           Multi-stage Node 20 + PHP 8.3 Apache production container
└── .github/workflows/   ci.yml (GitHub Actions CI pipeline)
```

---

## 🎨 Customizing Your Content & Media

See **[docs/ASSETS-TODO.md](docs/ASSETS-TODO.md)** for a complete checklist of:
1. Updating your personal profile & social links in `.env`.
2. Editing projects, case study metrics, skills, and career timeline in `app/Database/Seeds/`.
3. Replacing `public/assets/img/projects/<slug>/*`, `public/assets/img/portrait.svg`, and `public/cv.pdf`.

---

## 📄 License

Released under the **MIT License**. See [LICENSE](LICENSE) for details.
