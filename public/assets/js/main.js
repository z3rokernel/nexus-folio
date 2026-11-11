/**
 * public/assets/js/main.js — NEXUS-FOLIO Application Bootstrapper
 */
import { initState } from './core/state.js';
import { initLenis } from './core/lenis.js';
import { initBarba, initAllPageModules } from './core/barba.js';
import { initPreloader } from './modules/preloader.js';
import { initCursor } from './modules/cursor.js';
import { initGrain } from './modules/grain.js';
import { initHudGlobal } from './modules/hud.js';
import { initHeroShader } from './modules/hero-shader.js';
import { initCommandPalette } from './modules/command-palette.js';
import { initSoundGlobal } from './modules/sound.js';
import { initKonamiAndEasterEggs } from './modules/konami.js';

function boot() {
  // Register GSAP Plugins
  if (window.gsap) {
    const plugins = [
      window.ScrollTrigger,
      window.SplitText,
      window.ScrambleTextPlugin,
      window.Flip,
      window.CustomEase,
      window.Draggable,
      window.InertiaPlugin,
    ].filter(Boolean);
    window.gsap.registerPlugin(...plugins);
  }

  // Initialize Core State, Smooth Scroll & Global Chrome
  initState();
  initLenis();
  initCursor();
  initGrain();
  initHudGlobal();
  initSoundGlobal();
  initCommandPalette();
  initKonamiAndEasterEggs();
  initHeroShader();

  // Run AI Preloader, then initialize current page modules & Barba router
  const container = document.querySelector('[data-barba="container"]') || document;
  initPreloader(() => {
    initAllPageModules(container);
    initBarba();
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot);
} else {
  boot();
}
