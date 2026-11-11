# Rule: Frontend & motion (always on)
- Theme tokens live in CSS variables (`:root`) — see `docs/01`. Never hardcode hex values in components.
- Use GSAP for all tweening; use `gsap.matchMedia()` for responsive + reduced-motion branches.
- Lenis drives scroll; sync it with ScrollTrigger: `lenis.on('scroll', ScrollTrigger.update)` and `gsap.ticker.add(t => lenis.raf(t*1000))`, `gsap.ticker.lagSmoothing(0)`.
- Animate only `transform`, `opacity`, `filter` (sparingly), and shader uniforms. Never animate layout properties (width/top/left).
- WebGL: one shared renderer where possible, cap DPR at 2, pause when tab hidden or canvas offscreen (IntersectionObserver), dispose geometries/materials/textures on teardown.
- Provide a "Reduce motion" toggle in the UI plus honor `prefers-reduced-motion`.
- Touch devices: disable custom cursor & heavy shaders; use lighter fallbacks.
- Lazy-load videos (`preload="none"`, poster) and play on hover/in-view only.
