# 01 — Vision & Design System

## Concept: "NEXUS-FOLIO"
A portfolio presented as a **generative-AI film studio interface**. The visitor doesn't "browse a site" — they enter a dark control room where projects are *scenes* on a timeline. Every interaction should feel like operating futuristic software: precise, cinematic, slightly dangerous.

**Keywords:** cinematic · neo-noir · chrome · acid-lime · HUD · grain · liquid light · kinetic type · monospace metadata.

## Color tokens (CSS variables)
```css
:root{
  --void:        #05060A;   /* page background */
  --ink:         #0B0D14;   /* surfaces */
  --graphite:    #151925;   /* cards */
  --line:        rgba(255,255,255,.08);
  --text:        #EDEFF5;
  --text-dim:    #8A90A6;
  --acid:        #D4FF1F;   /* PRIMARY accent (lime) */
  --acid-glow:   rgba(212,255,31,.35);
  --plasma:      #7B5CFF;   /* secondary (violet) */
  --cyan:        #2DE2E6;   /* tertiary, data/HUD */
  --danger:      #FF3B5C;
  --chrome: linear-gradient(135deg,#fff 0%,#9aa3b8 35%,#fff 50%,#6b7390 70%,#e9ecf5 100%);
  --radius: 20px;
  --ease-out: cubic-bezier(.16,1,.3,1);
}
```
Provide an optional **theme switcher** (Acid / Plasma / Cyan) that swaps `--acid` live (animated) — saved in `localStorage`.

## Typography
| Role | Font | Notes |
|---|---|---|
| Display | **"Unbounded"** or **"Syne"** (Google Fonts) | huge, tight tracking (-0.03em), uppercase headlines, clamp(3rem, 11vw, 12rem) |
| Body | **"Inter Tight"** | 16–18px, line-height 1.6 |
| Mono/HUD | **"JetBrains Mono"** or **"Space Mono"** | small caps labels, coordinates, timestamps |

Use `font-display: swap`; preload the display font.

## Visual language
- **Film grain overlay**: fixed full-screen animated noise (CSS or tiny WebGL), opacity .06, `mix-blend-mode: overlay`, `pointer-events:none`.
- **HUD frame**: thin 1px corner brackets on viewport edges, live clock, scroll % indicator, coordinates following cursor (`X:0412 Y:0230`), section index `01/05`.
- **Glass cards**: `backdrop-filter: blur(20px)`, 1px gradient border (acid → transparent), inner glow on hover.
- **Chrome text**: hero word filled with `--chrome` gradient + animated shine sweep.
- **Grid**: 12-col, generous whitespace, asymmetry. Large type bleeds off-screen edges intentionally.
- **Depth**: layered parallax (bg shader → grid lines → content → grain → cursor).
- **Iconography**: thin 1.5px stroke (Lucide via CDN) — nothing filled/cartoonish.

## Voice & microcopy
Terse, confident, system-like: `INITIALIZING…`, `SCENE 03 / 06`, `RENDER COMPLETE`, `> hire_me --now`. Avoid corporate filler.

## Responsive
Breakpoints 390 / 768 / 1024 / 1440 / 1920. Mobile gets: no custom cursor, lighter shader (lower resolution, 30fps cap), vertical project stack instead of horizontal reel, hamburger → full-screen menu with staggered reveal.

## Acceptance criteria
- Contrast AA for all body text; accent text only ≥ 18px or bold.
- Screenshot of hero at 1440 looks like a film poster: huge type, glowing shader, HUD details visible.
