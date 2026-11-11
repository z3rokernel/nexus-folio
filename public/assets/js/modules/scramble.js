/**
 * modules/scramble.js — ScrambleText Hover Micro-interactions for [data-scramble]
 */
import { prefersReduced } from '../core/motion-prefs.js';

let cleanups = [];

export function initScramble(container = document) {
  destroyScramble();
  if (!window.gsap || !window.ScrambleTextPlugin) return;

  const gsap = window.gsap;
  const links = container.querySelectorAll('[data-scramble]');

  links.forEach((el) => {
    const original = el.getAttribute('data-scramble') || el.textContent.trim();

    const onEnter = () => {
      if (prefersReduced()) return;
      gsap.to(el, {
        duration: 0.45,
        scrambleText: {
          text: original,
          chars: '01/#X$<>_',
          speed: 0.6,
        },
        overwrite: 'auto',
      });
    };

    el.addEventListener('pointerenter', onEnter);
    cleanups.push(() => el.removeEventListener('pointerenter', onEnter));
  });
}

export function destroyScramble() {
  cleanups.forEach((fn) => fn());
  cleanups = [];
}
