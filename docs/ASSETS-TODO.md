# 🎨 ASSETS-TODO — Customizing Your Media & Personal Content

**mabdeira.dev** ships with procedural SVG project covers and a valid CV so the site works out-of-the-box with zero broken links. Follow the checklist below when you are ready to swap in your own photography, project screenshots, and video loops.

---

## 1. Personal Profile & Metadata (`.env` & `app/Database/Seeds/`)

Update these environment variables in `.env`:
- `PORTFOLIO_NAME`: Your full display name (default: `Mostepha Amine Bdeira`)
- `PORTFOLIO_HANDLE`: Short HUD mark (default: `MABDEIRA.DEV`)
- `PORTFOLIO_CITY`: Displayed in the top HUD bar (default: `Lyon, France`)
- `PORTFOLIO_TIMEZONE`: IANA timezone for live HUD clock (default: `Europe/Paris`)
- `PORTFOLIO_EMAIL`: Contact & click-to-copy email address (`contact@mabdeira.dev`)
- `PORTFOLIO_PHONE`: Phone number (`+33 6 15 21 88 14`)
- `GITHUB_USER`: Your GitHub handle for `/api/github` live contribution stats (`z3rokernel`)
- `GITHUB_TOKEN`: (Optional) Personal Access Token to raise GitHub GraphQL/REST rate limits

---

## 2. Portrait & Background Music MP3 (`public/assets/`)

| File Path | Recommended Spec | Notes |
|---|---|---|
| `public/assets/img/portrait.svg` (or `.webp` / `.jpg`) | `900×1100` (4:5 portrait), `< 180 KB` | Used on `/about` with duotone/halftone scanline shader |
| `public/assets/audio/bgm.mp3` | `.mp3` audio track (`128–192 kbps`, looped) | Played by the HUD **`BGM`** button (`#hud-bgm-btn`) in [sound.js](file:///d:/PORTFOLIO/public/assets/js/modules/sound.js). Drop any `.mp3` song here to use your own soundtrack! |

---

## 3. Project Covers, Loops & Case Study Galleries

Each project lives in `public/assets/img/projects/<slug>/` and is seeded via `app/Database/Seeds/ProjectSeeder.php`:

1. **`shopping-france`** (`shoppingfrance.store`)
   - `public/assets/img/projects/shopping-france/cover.svg` → Replace with `1920×1080` WebP/AVIF screenshot of `shoppingfrance.store`
   - `public/assets/img/projects/shopping-france/detail-01.svg` → Gallery frame 1
   - `public/assets/img/projects/shopping-france/detail-02.svg` → Gallery frame 2
2. **`deep-learning-elearning`** (Master Thesis — UCBET)
   - `public/assets/img/projects/deep-learning-elearning/cover.svg`
3. **`m4b-enterprise-suite`** (M4B Designs — 30+ SMB Web Platforms)
   - `public/assets/img/projects/m4b-enterprise-suite/cover.svg`
4. **`api-qa-sentinel`** (REST API & QA Test Suite)
   - `public/assets/img/projects/api-qa-sentinel/cover.svg`
5. **`aether-engine`** (MABDEIRA Shader Lab)
   - `public/assets/img/projects/aether-engine/cover.svg`
6. **`seo-cms-accelerator`** (SEO & CMS Accelerator)
   - `public/assets/img/projects/seo-cms-accelerator/cover.svg`

After editing `app/Database/Seeds/ProjectSeeder.php`, `SkillSeeder.php`, or `ExperienceSeeder.php`, re-seed with:
```bash
php spark db:seed DatabaseSeeder
```

