# 🎨 ASSETS-TODO — Customizing Your Media & Personal Content

NEXUS-FOLIO ships with high-contrast procedural SVG studio covers and a valid placeholder CV so the site works out-of-the-box with zero broken links. Follow the checklist below when you are ready to swap in your own photography, project screenshots, and video loops.

---

## 1. Personal Profile & Metadata (`.env` & `app/Database/Seeds/`)

Update these environment variables in `.env`:
- `PORTFOLIO_NAME`: Your full display name (default: `Mostepha Amine BDEIR`)
- `PORTFOLIO_HANDLE`: Short HUD studio mark (default: `NXS//STUDIO`)
- `PORTFOLIO_CITY`: Displayed in the top HUD bar (default: `Paris, France`)
- `PORTFOLIO_TIMEZONE`: IANA timezone for live HUD clock (default: `Europe/Paris`)
- `PORTFOLIO_EMAIL`: Contact & click-to-copy email address
- `GITHUB_USER`: Your GitHub handle for `/api/github` live contribution stats
- `GITHUB_TOKEN`: (Optional) Personal Access Token to raise GitHub GraphQL/REST rate limits

---

## 2. Portrait & Resume (`public/`)

| File Path | Recommended Spec | Notes |
|---|---|---|
| `public/assets/img/portrait.svg` (or `.webp` / `.jpg`) | `900×1100` (4:5 portrait), `< 180 KB` | Used on `/about` with duotone/halftone scanline shader |
| `public/cv.pdf` | Standard A4 PDF | Linked from the About page and the `Ctrl/⌘+K` Command Palette |

---

## 3. Project Covers, Loops & Case Study Galleries

Each project lives in `public/assets/img/projects/<slug>/` and is seeded via `app/Database/Seeds/ProjectSeeder.php`:

1. **`aether-engine`**
   - `public/assets/img/projects/aether-engine/cover.svg` → Replace with `1920×1080` WebP/AVIF cover
   - `public/assets/img/projects/aether-engine/detail-01.svg` → Gallery frame 1
   - `public/assets/img/projects/aether-engine/detail-02.svg` → Gallery frame 2
   - *(Optional)* `public/assets/video/aether-engine.mp4` (`1280×720`, `≤ 6s`, muted H.264/WebM loop, `≤ 2 MB`)
2. **`kronos-neural-hud`**
   - `public/assets/img/projects/kronos-neural-hud/cover.svg`
3. **`synapse-rag-os`**
   - `public/assets/img/projects/synapse-rag-os/cover.svg`
4. **`hyperion-synth`**
   - `public/assets/img/projects/hyperion-synth/cover.svg`
5. **`void-commerce`**
   - `public/assets/img/projects/void-commerce/cover.svg`
6. **`prism-shader-kit`**
   - `public/assets/img/projects/prism-shader-kit/cover.svg`

After editing `app/Database/Seeds/ProjectSeeder.php`, `SkillSeeder.php`, or `ExperienceSeeder.php`, re-seed with:
```bash
php spark db:seed DatabaseSeeder
```
