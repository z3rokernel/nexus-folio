/**
 * modules/marquee.js — Infinite Horizontal Ticker Reacting to Lenis Scroll Velocity
 */
import { prefersReduced } from '../core/motion-prefs.js';
import { state } from '../core/state.js';

let rafId = null;

export function initMarquee(container = document) {
  destroyMarquee();
  if (prefersReduced()) return;

  const rows = Array.from(container.querySelectorAll('[data-marquee-row]')).map((el) => ({
    el,
    dir: parseFloat(el.getAttribute('data-marquee-row') || '1'),
    x: 0,
  }));

  if (rows.length === 0) return;

  function step() {
    const velBoost = Math.min(4.5, Math.abs(state.scrollVelocity || 0) * 0.08);
    const scrollDir = state.scrollDirection || 1;

    rows.forEach((row) => {
      const speed = (0.045 + velBoost * 0.05) * row.dir * scrollDir;
      row.x -= speed;
      if (row.x <= -50) row.x += 50;
      if (row.x > 0) row.x -= 50;
      row.el.style.transform = `translate3d(${row.x}%, 0, 0)`;
    });

    rafId = requestAnimationFrame(step);
  }

  rafId = requestAnimationFrame(step);
}

export function destroyMarquee() {
  if (rafId) {
    cancelAnimationFrame(rafId);
    rafId = null;
  }
}

