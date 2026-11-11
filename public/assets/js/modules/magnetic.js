/**
 * modules/magnetic.js — Magnetic pull for [data-magnetic] + Liquid Fill Origin for .btn-nexus
 */
import { isTouchDevice } from '../core/utils.js';
import { prefersReduced, EASE } from '../core/motion-prefs.js';

let cleanups = [];

export function initMagnetic(container = document) {
  destroyMagnetic();
  if (isTouchDevice() || !window.gsap) return;

  const gsap = window.gsap;
  const elements = container.querySelectorAll('[data-magnetic]');

  elements.forEach((el) => {
    const onMove = (e) => {
      const rect = el.getBoundingClientRect();
      const relX = e.clientX - rect.left;
      const relY = e.clientY - rect.top;

      // Update CSS vars for liquid fill button entry point
      el.style.setProperty('--fill-x', `${Math.round((relX / rect.width) * 100)}%`);
      el.style.setProperty('--fill-y', `${Math.round((relY / rect.height) * 100)}%`);

      if (prefersReduced()) return;

      const dx = (e.clientX - (rect.left + rect.width / 2)) * 0.28;
      const dy = (e.clientY - (rect.top + rect.height / 2)) * 0.28;

      gsap.to(el, {
        x: dx,
        y: dy,
        duration: 0.35,
        ease: 'power3.out',
        overwrite: 'auto',
      });
    };

    const onLeave = () => {
      if (prefersReduced()) return;
      gsap.to(el, {
        x: 0,
        y: 0,
        duration: 0.7,
        ease: EASE.spring,
        overwrite: 'auto',
      });
    };

    el.addEventListener('pointermove', onMove);
    el.addEventListener('pointerleave', onLeave);
    cleanups.push(() => {
      el.removeEventListener('pointermove', onMove);
      el.removeEventListener('pointerleave', onLeave);
      gsap.set(el, { clearProps: 'x,y' });
    });
  });
}

export function destroyMagnetic() {
  cleanups.forEach((fn) => fn());
  cleanups = [];
}
