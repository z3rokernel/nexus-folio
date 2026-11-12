/**
 * modules/image-distort.js — Hover Chromatic & Liquid Displacement Micro-Effect on Project Media
 */
import { prefersReduced } from '../core/motion-prefs.js';

let cleanups = [];

export function initImageDistort(container = document) {
  destroyImageDistort();
  if (prefersReduced() || !window.gsap) return;

  const gsap = window.gsap;
  const images = container.querySelectorAll('[data-distort-img], [data-reel-img]');

  images.forEach((img) => {
    const onEnter = () => {
      gsap.fromTo(
        img,
        { filter: 'contrast(1.35) brightness(1.15) hue-rotate(18deg)' },
        { filter: 'contrast(1) brightness(1) hue-rotate(0deg)', duration: 0.55, ease: 'power2.out' }
      );
    };

    img.addEventListener('pointerenter', onEnter);
    cleanups.push(() => img.removeEventListener('pointerenter', onEnter));
  });
}

export function destroyImageDistort() {
  cleanups.forEach((fn) => fn());
  cleanups = [];
}

