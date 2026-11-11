/**
 * modules/tilt-cards.js — 3D Pointer Tilt + Specular Radial Highlight for [data-tilt]
 */
import { isTouchDevice } from '../core/utils.js';
import { prefersReduced } from '../core/motion-prefs.js';

let cleanups = [];

export function initTiltCards(container = document) {
  destroyTiltCards();
  if (isTouchDevice() || !window.gsap) return;

  const gsap = window.gsap;
  const cards = container.querySelectorAll('[data-tilt]');

  cards.forEach((card) => {
    const onMove = (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      card.style.setProperty('--mouse-x', `${Math.round(x)}px`);
      card.style.setProperty('--mouse-y', `${Math.round(y)}px`);

      if (prefersReduced()) return;

      const rotY = ((x / rect.width - 0.5) * 10).toFixed(2);
      const rotX = ((0.5 - y / rect.height) * 10).toFixed(2);

      gsap.to(card, {
        rotateX: parseFloat(rotX),
        rotateY: parseFloat(rotY),
        transformPerspective: 1000,
        duration: 0.4,
        ease: 'power2.out',
        overwrite: 'auto',
      });
    };

    const onLeave = () => {
      if (prefersReduced()) return;
      gsap.to(card, {
        rotateX: 0,
        rotateY: 0,
        duration: 0.65,
        ease: 'power3.out',
        overwrite: 'auto',
      });
    };

    card.addEventListener('pointermove', onMove);
    card.addEventListener('pointerleave', onLeave);
    cleanups.push(() => {
      card.removeEventListener('pointermove', onMove);
      card.removeEventListener('pointerleave', onLeave);
      gsap.set(card, { clearProps: 'rotateX,rotateY,transformPerspective' });
    });
  });
}

export function destroyTiltCards() {
  cleanups.forEach((fn) => fn());
  cleanups = [];
}
