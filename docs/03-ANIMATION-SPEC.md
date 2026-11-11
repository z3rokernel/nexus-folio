# 03 — Animation & Interaction Spec (the heart of the site)

## 1. Libraries & pinned CDNs
Load in `layouts/main.php` (defer / module). Verify versions exist before use; pin exact versions.
```html
<!-- GSAP core + ALL plugins are free (3.13+) -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrambleTextPlugin.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Flip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/CustomEase.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Draggable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/InertiaPlugin.min.js"></script>
<!-- Smooth scroll -->
<script src="https://cdn.jsdelivr.net/npm/lenis@1.3.4/dist/lenis.min.js"></script>
<!-- Page transitions -->
<script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3/dist/barba.umd.js"></script>
<!-- Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
```
Three.js via importmap (ES module):
```html
<script type="importmap">{"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js","three/addons/":"https://cdn.jsdelivr.net/npm/three@0.170.0/examples/jsm/"}}</script>
<script type="module" src="/assets/js/main.js"></script>
```
Optional: `howler@2.2.4` (UI sounds), `vanilla-tilt` (fallback tilt), `matter-js` (physics skills playground).

## 2. JS architecture
```
public/assets/js/
├── main.js              # boot: register plugins, lenis, barba, init modules
├── core/{lenis.js, barba.js, state.js, utils.js, motion-prefs.js}
├── modules/
│   ├── preloader.js  cursor.js  hud.js  grain.js  magnetic.js
│   ├── split-reveal.js  scramble.js  marquee.js  tilt-cards.js
│   ├── hero-shader.js  project-reel.js  image-distort.js
│   ├── skills-physics.js  command-palette.js  github-stats.js
│   └── transitions.js
└── shaders/{hero.frag.glsl, hero.vert.glsl, distort.frag.glsl, ripple.frag.glsl}
```
Each module exports `init(container)` and `destroy()`. `barba` hooks call `destroyAll()` on `beforeLeave`, `initAll(next.container)` on `afterEnter`, then `ScrollTrigger.refresh()`.

## 3. Preloader — "Generating…" (AI-render style)
- Full-screen black; mono text `> generating portfolio…` scrambles (ScrambleText) while a **0→100 counter** ticks with non-linear easing.
- Behind it: a small WebGL noise square that "resolves" from pixelated blur to sharp (shader uniform `uPixel` 64→1).
- Exit: counter shrinks into the HUD, curtain splits in two panels (clip-path) revealing the hero; hero headline reveals right after (stagger).
- Plays **once per session** (`sessionStorage`), skipped for reduced motion (fade only).
- **Acceptance:** < 3.2s total, no layout shift.

## 4. Hero — Liquid Shader Stage
- Fullscreen Three.js plane with a custom **fragment shader**: domain-warped fbm noise in violet/lime/cyan over black, subtle chrome flow lines.
- **Mouse interaction:** lerped mouse position as uniform → local distortion ripple + glow (like light under liquid). Velocity-based intensity.
- **Scroll interaction:** `uScroll` darkens/zooms the field as the hero leaves.
- Headline (`<h1>`): SplitText by chars → rise from `yPercent:120` with `rotateX`, stagger 0.03, `expo.out`; chrome shine sweep loops every 6s.
- Sub-copy typed with ScrambleText; CTA buttons are **magnetic** with a lime fill that wipes in from cursor entry direction.
- Floating **3D object** (optional): a chrome torus-knot / icosahedron with `MeshPhysicalMaterial` (iridescence), PMREM environment from a procedural gradient (no external HDR). Rotates slowly, tilts toward cursor.
- Fallback (mobile/reduced-motion): static CSS gradient mesh with slow `background-position` drift.
- **Acceptance:** 60fps at 1440×900, DPR capped 1.75, pauses offscreen.

## 5. Scroll system
- **Lenis** (`lerp:0.085`, `smoothWheel:true`), synced with ScrollTrigger (see rules).
- Scroll progress bar in HUD + section counter updates via ScrollTrigger `onToggle`.
- **Section transitions:** background color shifts (void → ink → void) tied to scroll; large section titles pinned with `scrub` and **text mask reveal** (SplitText lines, `overflow:hidden` wrappers).
- **Parallax:** elements with `data-speed="0.8|1.2"` move via `y` scrub.

## 6. Project Reel (signature feature)
Desktop: **horizontal scroll reel** pinned with ScrollTrigger (`pin:true`, `scrub:1`, `end:"+=300%"`). Each project is a big "scene" card:
- Number `01`, title in huge outlined type (`-webkit-text-stroke`) that fills with lime on hover.
- Media: video/image rendered in a **WebGL plane with image-displacement hover** (Three.js; mouse-driven ripple + RGB-split + liquid distortion using a displacement map generated procedurally). Fallback `<img>` for no-WebGL.
- Active card scales to 1, neighbors `scale .85, opacity .5, blur 2px` (progress-based).
- **Cursor morphs** to a circular "VIEW" label with rotating text ring when over a card; click → Flip-style **expand transition** into the case-study page (shared-element feel via GSAP Flip + Barba).
- Mobile: vertical stack, each card reveals with clip-path wipe; tap to open.
- Keyboard: ←/→ moves between scenes when reel is focused. Include a visible "Scene 02 / 06" + progress line.

## 7. Custom cursor (desktop only)
- Two layers: dot (instant) + ring (lerp .15). `mix-blend-mode: difference`.
- States via `data-cursor="view|drag|play|link|text"`: ring grows, shows label, dot hides. On text selection → I-beam morph.
- Velocity stretch: ring scaleX/rotate according to velocity vector (squash & stretch).
- Click → ripple pulse. Hide on `pointerType === 'touch'`.

## 8. Text & micro-interactions
- **Split reveals:** `[data-split="lines|words|chars"]` auto-wired; triggered at `top 85%`.
- **Scramble links:** nav links scramble to their text on hover.
- **Magnetic buttons/icons:** `[data-magnetic]` pulls toward cursor within 80px, springs back with `elastic.out(1,.4)`.
- **Marquee:** infinite horizontal ticker of tech stack; speed reacts to scroll velocity and reverses with scroll direction (Lenis velocity).
- **3D tilt cards:** pointer-based `rotateX/rotateY` + moving specular highlight (CSS radial-gradient following cursor), `perspective:1000px`.
- **Number counters** (stats) with `snap` and mono font.
- **Underline draw / border-trace** SVG strokes (`DrawSVG`-like via `strokeDashoffset`).
- **Buttons:** liquid fill (clip-path circle expanding from pointer entry point).

## 9. Page transitions (Barba + GSAP)
- Leave: 5 vertical lime→black **slices** (clip-path/scaleY, stagger from center), page title of destination flashes in mono, WebGL canvas continues running (persist in `data-barba="wrapper"` outside the container).
- Enter: slices retract, content `y:60 → 0` + stagger of `[data-reveal]`.
- Project → case-study: Flip the clicked card's media into the case-study hero.
- Prefetch on hover (`@barba/prefetch`) and update `<title>`, meta, active nav state, HUD index.
- **Acceptance:** no scroll jump, back button works, JS modules cleaned (verify with a heap/ScrollTrigger count check: `ScrollTrigger.getAll().length` returns to baseline).

## 10. 🎁 "Wow" features & Easter eggs (implement these!)
1. **Command Palette (Ctrl/⌘+K):** glass modal, fuzzy search over pages/projects/actions ("Copy email", "Download CV", "Toggle sound", "Switch theme"), arrow-key navigation, animated list with Flip.
2. **Live GitHub Stats panel:** CI4 endpoint `/api/github` (cached 1h) → animated contribution heat-grid (canvas) that "renders in" cell-by-cell with a wave from cursor.
3. **Skills Physics Playground:** Matter.js — skill chips drop from the sky as rigid bodies; drag & throw them; they react to scroll shake. (Fallback: static tag cloud.)
4. **Konami Code (↑↑↓↓←→←→BA):** triggers "GLITCH MODE": RGB-split post effect on hero, scanlines, glitch text, `INTRUDER DETECTED` toast; reversible.
5. **Cursor trail of light** in the Contact section (WebGL fluid-like smoke; use a cheap ping-pong FBO ripple/sim, or canvas particles fallback).
6. **Sound design (opt-in toggle, default OFF):** subtle UI ticks on hover/click, ambient hum fade-in. Howler.js. Persist preference.
7. **Idle mode:** after 20s inactivity the hero shader slowly "breathes" and a mono prompt appears `> still there?`.
8. **Time-aware HUD:** local time + "Based in <city>" + day/night accent shift.
9. **Text-to-terminal About:** About section is a terminal that types commands (`whoami`, `cat skills.txt`, `ls projects/`) with real output lines; user can type actual commands (`help`, `projects`, `contact`, `theme acid`).
10. **View-source greeting:** console.log ASCII art + "Hiring? hello@yourdomain.com".

## 11. Motion tokens
```js
export const EASE = { out:'expo.out', inOut:'power4.inOut', soft:'power3.out', spring:'elastic.out(1,.4)' };
export const DUR  = { xs:.2, sm:.45, md:.8, lg:1.2, xl:1.8 };
export const STAGGER = { chars:.025, words:.06, lines:.12, cards:.1 };
```

## 12. Reduced motion & performance guardrails
- `motion-prefs.js` exposes `prefersReduced()`; all modules branch on it (no pinning/scrub, no shaders, fades only ≤ 200ms).
- Pause GSAP ticker + RAF loops on `document.hidden`.
- Throttle pointermove with RAF; use `will-change` only during animation.
- Test CPU 4× slowdown in DevTools: must remain usable.
