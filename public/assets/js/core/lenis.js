/**
 * core/lenis.js — Smooth Scroll (Lenis v1.3.4) synced with GSAP ScrollTrigger
 */
import { prefersReduced } from './motion-prefs.js';
import { state } from './state.js';

let lenisInstance = null;
let tickerCallback = null;

export function initLenis() {
  if (lenisInstance) return lenisInstance;
  if (prefersReduced() || !window.Lenis || !window.gsap) {
    return null;
  }

  lenisInstance = new window.Lenis({
    lerp: 0.085,
    smoothWheel: true,
    wheelMultiplier: 1.0,
    touchMultiplier: 1.5,
  });

  lenisInstance.on('scroll', (e) => {
    state.scrollProgress = e.progress || 0;
    state.scrollVelocity = e.velocity || 0;
    state.scrollDirection = e.direction || 1;
    if (window.ScrollTrigger) {
      window.ScrollTrigger.update();
    }
  });

  tickerCallback = (time) => {
    if (lenisInstance && !document.hidden) {
      lenisInstance.raf(time * 1000);
    }
  };

  window.gsap.ticker.add(tickerCallback);
  window.gsap.ticker.lagSmoothing(0);

  return lenisInstance;
}

export function getLenis() {
  return lenisInstance;
}

export function stopScroll() {
  if (lenisInstance) lenisInstance.stop();
}

export function startScroll() {
  if (lenisInstance && !prefersReduced()) lenisInstance.start();
}

export function scrollToTop() {
  if (lenisInstance) {
    lenisInstance.scrollTo(0, { duration: 1.2 });
  } else {
    window.scrollTo({ top: 0, behavior: prefersReduced() ? 'auto' : 'smooth' });
  }
}

export function destroyLenis() {
  if (tickerCallback && window.gsap) {
    window.gsap.ticker.remove(tickerCallback);
    tickerCallback = null;
  }
  if (lenisInstance) {
    lenisInstance.destroy();
    lenisInstance = null;
  }
}
