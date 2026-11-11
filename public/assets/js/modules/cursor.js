/**
 * modules/cursor.js — Dual-layer velocity-stretched custom cursor (Desktop only)
 */
import { isTouchDevice, lerp } from '../core/utils.js';
import { prefersReduced } from '../core/motion-prefs.js';
import { state } from '../core/state.js';

let rafId = null;

export function initCursor() {
  if (isTouchDevice()) return;

  const dot = document.getElementById('nexus-cursor-dot');
  const ring = document.getElementById('nexus-cursor-ring');
  const label = document.getElementById('nexus-cursor-label');
  if (!dot || !ring || !label) return;

  document.body.classList.add('has-custom-cursor');

  let targetX = window.innerWidth / 2;
  let targetY = window.innerHeight / 2;
  let ringX = targetX;
  let ringY = targetY;
  let prevX = targetX;
  let prevY = targetY;

  window.addEventListener(
    'pointermove',
    (e) => {
      if (e.pointerType === 'touch') return;
      targetX = e.clientX;
      targetY = e.clientY;

      state.mouse.px = e.clientX;
      state.mouse.py = e.clientY;
      state.mouse.x = e.clientX / window.innerWidth;
      state.mouse.y = 1.0 - e.clientY / window.innerHeight;

      dot.style.transform = `translate3d(${targetX}px, ${targetY}px, 0)`;

      const coordsEl = document.getElementById('hud-coords');
      if (coordsEl) {
        const cx = String(Math.round(targetX)).padStart(4, '0');
        const cy = String(Math.round(targetY)).padStart(4, '0');
        coordsEl.textContent = `X:${cx} Y:${cy}`;
      }
    },
    { passive: true }
  );

  // Morph states via delegated pointerover
  document.addEventListener(
    'pointerover',
    (e) => {
      const el = e.target && e.target.closest ? e.target.closest('[data-cursor]') : null;
      if (el) {
        const mode = (el.getAttribute('data-cursor') || 'view').toUpperCase();
        ring.classList.add('is-expanded');
        label.textContent = mode;
        dot.style.opacity = '0';
      } else {
        ring.classList.remove('is-expanded');
        dot.style.opacity = '1';
      }
    },
    { passive: true }
  );

  // Click pulse
  window.addEventListener('pointerdown', () => {
    ring.style.transform += ' scale(0.84)';
  });

  function render() {
    ringX = lerp(ringX, targetX, 0.16);
    ringY = lerp(ringY, targetY, 0.16);

    const vx = ringX - prevX;
    const vy = ringY - prevY;
    prevX = ringX;
    prevY = ringY;

    state.mouse.vx = vx;
    state.mouse.vy = vy;

    if (!prefersReduced() && !ring.classList.contains('is-expanded')) {
      const speed = Math.min(Math.hypot(vx, vy), 28);
      const angle = Math.atan2(vy, vx) * (180 / Math.PI);
      const scaleX = 1 + (speed / 28) * 0.35;
      const scaleY = 1 - (speed / 28) * 0.18;
      ring.style.transform = `translate3d(${ringX}px, ${ringY}px, 0) rotate(${angle}deg) scale(${scaleX}, ${scaleY})`;
    } else {
      ring.style.transform = `translate3d(${ringX}px, ${ringY}px, 0)`;
    }

    rafId = requestAnimationFrame(render);
  }

  rafId = requestAnimationFrame(render);
}

export function resetCursorState() {
  const ring = document.getElementById('nexus-cursor-ring');
  const dot = document.getElementById('nexus-cursor-dot');
  if (ring) ring.classList.remove('is-expanded');
  if (dot) dot.style.opacity = '1';
}
