/**
 * modules/light-trail.js — Interactive Fluid Light-Trail Canvas for CTA & Contact Sections
 */
import { prefersReduced } from '../core/motion-prefs.js';
import { state, THEME_COLORS } from '../core/state.js';

let rafId = null;
let cleanups = [];

export function initLightTrail(container = document) {
  destroyLightTrail();
  if (prefersReduced()) return;

  const canvas = container.querySelector('#cta-light-trail, #contact-trail-canvas');
  if (!canvas) return;

  const parent = canvas.parentElement;
  if (!parent) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const resize = () => {
    const r = parent.getBoundingClientRect();
    canvas.width = Math.max(300, Math.floor(r.width));
    canvas.height = Math.max(300, Math.floor(r.height));
  };
  resize();
  window.addEventListener('resize', resize, { passive: true });

  const particles = [];

  const onMove = (e) => {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    for (let i = 0; i < 2; i++) {
      particles.push({
        x: x + (Math.random() - 0.5) * 14,
        y: y + (Math.random() - 0.5) * 14,
        vx: (Math.random() - 0.5) * 1.4,
        vy: (Math.random() - 0.5) * 1.4 - 0.4,
        radius: 18 + Math.random() * 28,
        alpha: 0.42,
      });
    }
    if (particles.length > 90) particles.splice(0, particles.length - 90);
  };

  parent.addEventListener('pointermove', onMove, { passive: true });
  cleanups.push(() => {
    window.removeEventListener('resize', resize);
    parent.removeEventListener('pointermove', onMove);
  });

  function render() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const rgb = (THEME_COLORS[state.theme] || THEME_COLORS.acid).rgb;
    const r = Math.round(rgb[0] * 255);
    const g = Math.round(rgb[1] * 255);
    const b = Math.round(rgb[2] * 255);

    for (let i = particles.length - 1; i >= 0; i--) {
      const p = particles[i];
      p.x += p.vx;
      p.y += p.vy;
      p.radius *= 0.985;
      p.alpha *= 0.95;

      if (p.alpha <= 0.01) {
        particles.splice(i, 1);
        continue;
      }

      const grad = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.radius);
      grad.addColorStop(0, `rgba(${r}, ${g}, ${b}, ${p.alpha})`);
      grad.addColorStop(1, `rgba(${r}, ${g}, ${b}, 0)`);

      ctx.fillStyle = grad;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
      ctx.fill();
    }

    rafId = requestAnimationFrame(render);
  }

  rafId = requestAnimationFrame(render);
}

export function destroyLightTrail() {
  if (rafId) {
    cancelAnimationFrame(rafId);
    rafId = null;
  }
  cleanups.forEach((fn) => fn());
  cleanups = [];
}

