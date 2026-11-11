# 04 — Pages & Components

## Global chrome (on every page)
- **HUD frame:** corner brackets, top-left logo mark `NXS//`, top-center live clock + city, top-right menu button (magnetic), bottom-left scroll %, bottom-right section index, bottom-center "scroll" hint that fades after first scroll.
- **Menu overlay:** full-screen, links as huge type with scramble-on-hover + image preview that follows cursor (WebGL or simple `<img>` with `quickTo`). Opens with clip-path circle from the button.
- **Footer:** giant outlined name that fills with lime as it scrolls into view, email (click-to-copy with toast), socials, "Back to top" with scroll-to via Lenis.

## Home `/`
1. **Hero** — liquid shader, huge name/title, tagline, 2 CTAs (`View work`, `Let's talk`), rotating role text (Full-Stack / Creative Dev / AI Builder), scroll hint.
2. **Intro statement** — paragraph with **word-by-word scrub reveal** (opacity .15 → 1 as you scroll), key words highlighted in lime.
3. **Project Reel** — horizontal pinned scenes (featured projects, 4–6). See spec §6.
4. **Marquee** — tech stack ticker (two rows, opposite directions).
5. **Capabilities** — 4 glass tilt-cards (e.g., Backend, Creative Frontend, AI Integration, DevOps) with animated line icons and hover-expanded details.
6. **Skills playground** — Matter.js physics chips (desktop), tag cloud fallback.
7. **Stats / GitHub** — counters (years, projects, commits) + contribution heat-grid.
8. **Process timeline** — vertical line draws on scroll; steps light up (Discover → Design → Build → Ship).
9. **CTA** — giant `LET'S BUILD SOMETHING IMPOSSIBLE` with cursor-light-trail; email button.

## Work `/work`
- Filter chips (All / Web / AI / Mobile / Open Source) — filtering animated with **GSAP Flip** (cards reorder smoothly).
- Grid toggle: **Grid ↔ List** (list = big titles with hover media preview following cursor).
- Cards: tilt + video preview on hover.

## Case study `/work/{slug}`
- Hero: Flip-expanded media from the card, title, meta grid (Role / Year / Stack / Client / Links) in mono.
- Sections: Challenge → Approach → Solution → Result (counters), each with scroll-reveal.
- Media gallery: alternating full-bleed images / videos with parallax; lightbox with drag-to-close (Draggable + Inertia).
- Tech stack chips, live/repo buttons.
- **Next project** — giant footer link: next title fills the screen on hover, click triggers the transition.

## About `/about`
- Portrait with **duotone/halftone shader hover** (or CSS mask reveal) + short bio.
- **Terminal block** (see spec §10.9).
- Experience timeline (hover expands description), education, certifications.
- "Currently" widget: what I'm building / learning / listening to (static text from DB or `.env`).
- Download CV button (`/cv.pdf`).

## Contact `/contact`
- Large form with floating labels, animated focus underline, character counter, honeypot, CSRF.
- Submit via `fetch` (AJAX) → button morphs into a progress ring → success state "TRANSMISSION SENT" with confetti-like particle burst (lime). Errors shake gently and announce via `aria-live`.
- Alternative channels: email (copy), LinkedIn, GitHub, WhatsApp/Telegram (optional), local time + availability status (green pulsing dot "Available for freelance").

## 404
Glitchy `404` with RGB-split shader, text "SIGNAL LOST", button "Return to base".

## Component contracts
| Component | Props / data attributes | Notes |
|---|---|---|
| `project-card` | `$project`, `data-cursor="view"`, `data-tilt` | video src lazy-loaded on hover |
| `section-title` | `$index`, `$label`, `$title` | split-lines reveal, mono index `01 //` |
| `button` | `$label`, `$href`, `data-magnetic` | liquid fill hover |
| `skill-chip` | `$name`, `$category` | physics body in playground |
| `stat` | `$value`, `$label` | counter on enter |

## Acceptance criteria (global)
- Every page has exactly one `<h1>`, landmarks (`header/nav/main/footer`), skip-link, visible focus rings (lime outline).
- All interactive elements reachable by keyboard; Esc closes menu/palette/lightbox.
- Page transitions never break deep links (direct URL load renders the full page without JS).
