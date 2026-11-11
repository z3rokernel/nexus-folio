# 08 — Performance, Accessibility & QA

## Budgets
| Metric | Target |
|---|---|
| LCP | < 2.5s (4G, mid device) — hero text paints before the shader |
| CLS | < 0.05 |
| JS (excl. CDN libs) | < 150 KB gz |
| Initial CSS | < 40 KB gz |
| Images | AVIF/WebP, lazy, explicit `width/height` |
| Frame rate | 55–60fps scroll on 1440p; shader capped 30fps on mobile |

## WebGL hygiene
- Single `WebGLRenderer` for background; reel planes share it via scissor or separate small canvases only if needed.
- Dispose textures/materials on Barba leave; handle `webglcontextlost`.
- Detect WebGL via try/catch → apply `.no-webgl` class → CSS fallbacks.
- `renderer.setPixelRatio(Math.min(devicePixelRatio, 1.75))`.

## Accessibility
- Honor `prefers-reduced-motion`; add visible **Reduce motion** toggle in menu.
- Split-text: keep original text in `aria-label` on the parent and `aria-hidden` on the split spans.
- Focus management after Barba navigation: move focus to `<h1>` / main, announce page title via `aria-live="polite"`.
- Color is never the only signal; focus ring 2px lime offset 3px.
- Canvas elements `aria-hidden="true"`; videos muted, no autoplay audio, pause control for long loops.

## QA checklist
- Browsers: Chrome, Firefox, Safari (macOS/iOS), Edge. Safari: test `backdrop-filter`, 100vh → use `100svh`.
- Viewports: 390, 768, 1024, 1440, 1920.
- Throttle: CPU 4×, Network Fast 3G.
- Navigation: deep link, back/forward, refresh mid-transition, rapid double-click on links.
- Memory: navigate Home→Work→Case→Home ×10; `ScrollTrigger.getAll().length` stable; heap doesn't climb.
- Forms: invalid input, honeypot filled, 6 rapid submits (429), CSRF expired.
- Security: no `.env` in repo, CSP no violations in console, headers present, output escaped.
