/**
 * modules/transitions.js — 5-Slice Lime-to-Void Curtain + GSAP Flip Transition
 */
import { prefersReduced, EASE } from '../core/motion-prefs.js';
import { playTransitionSweep } from './sound.js';

export function playLeaveTransition(nextNamespace = 'SCENE') {
  const slices = document.querySelectorAll('#transition-stage .transition-slice');
  const labelWrap = document.getElementById('transition-label');
  const labelText = document.getElementById('transition-label-text');

  if (labelText) {
    labelText.textContent = `// LOADING SCENE: ${(nextNamespace || 'STUDIO').toUpperCase()}`;
  }

  playTransitionSweep();

  if (prefersReduced() || !window.gsap || slices.length === 0) {
    return Promise.resolve();
  }

  const gsap = window.gsap;
  return new Promise((resolve) => {
    const tl = gsap.timeline({ onComplete: resolve });
    gsap.set(slices, { transformOrigin: 'top center', scaleY: 0 });
    tl.to(slices, {
      scaleY: 1,
      duration: 0.48,
      stagger: { amount: 0.18, from: 'center' },
      ease: EASE.inOut,
    }).to(
      labelWrap,
      {
        opacity: 1,
        duration: 0.2,
      },
      '-=0.25'
    );
  });
}

export function playEnterTransition(nextContainer) {
  const slices = document.querySelectorAll('#transition-stage .transition-slice');
  const labelWrap = document.getElementById('transition-label');

  if (prefersReduced() || !window.gsap || slices.length === 0) {
    if (labelWrap) labelWrap.style.opacity = '0';
    return Promise.resolve();
  }

  const gsap = window.gsap;
  return new Promise((resolve) => {
    const tl = gsap.timeline({ onComplete: resolve });
    gsap.set(slices, { transformOrigin: 'bottom center' });

    tl.to(labelWrap, {
      opacity: 0,
      duration: 0.18,
    })
      .to(
        slices,
        {
          scaleY: 0,
          duration: 0.52,
          stagger: { amount: 0.18, from: 'edges' },
          ease: EASE.inOut,
        },
        '-=0.05'
      )
      .fromTo(
        nextContainer,
        { opacity: 0, y: 32 },
        { opacity: 1, y: 0, duration: 0.55, ease: EASE.out, clearProps: 'transform' },
        '-=0.35'
      );
  });
}
