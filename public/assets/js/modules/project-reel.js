/**
 * modules/project-reel.js — Pinned Horizontal Project Reel on Desktop + Keyboard Arrow Navigation
 */
import { prefersReduced } from '../core/motion-prefs.js';

let reelTrigger = null;
let keyCleanup = null;

export function initProjectReel(container = document) {
  destroyProjectReel();

  const section = container.querySelector('#scene-reel');
  const pinWrap = container.querySelector('#reel-pin-wrap');
  const track = container.querySelector('#reel-track');
  const counterEl = container.querySelector('#reel-counter');
  const progressBar = container.querySelector('#reel-progress-bar');

  if (!section || !pinWrap || !track) return;

  const cards = Array.from(track.querySelectorAll('[data-reel-card]'));
  const total = cards.length;
  if (total === 0) return;

  if (prefersReduced() || !window.gsap || !window.ScrollTrigger || window.innerWidth < 1024) {
    return;
  }

  const gsap = window.gsap;
  const ScrollTrigger = window.ScrollTrigger;

  const getScrollDistance = () => Math.max(0, track.scrollWidth - pinWrap.clientWidth + 64);

  const tween = gsap.to(track, {
    x: () => -getScrollDistance(),
    ease: 'none',
    scrollTrigger: {
      trigger: section,
      pin: pinWrap,
      scrub: 1,
      start: 'top top',
      end: () => `+=${Math.max(window.innerWidth * 2.2, getScrollDistance())}`,
      invalidateOnRefresh: true,
      onUpdate: (self) => {
        const progress = self.progress;
        const activeIdx = Math.min(total - 1, Math.max(0, Math.round(progress * (total - 1))));
        if (counterEl) {
          counterEl.textContent = `SCENE 0${activeIdx + 1} / 0${total}`;
        }
        if (progressBar) {
          progressBar.style.width = `${Math.max(12, Math.round(progress * 100))}%`;
        }

        cards.forEach((card, idx) => {
          const dist = Math.abs(idx - progress * (total - 1));
          const scale = Math.max(0.9, 1 - dist * 0.08);
          const opacity = Math.max(0.55, 1 - dist * 0.35);
          card.style.transform = `scale(${scale.toFixed(3)})`;
          card.style.opacity = opacity.toFixed(2);
        });
      },
    },
  });

  reelTrigger = tween.scrollTrigger;

  // Keyboard Arrow Navigation when Reel is focused
  const onKeyDown = (e) => {
    if (!reelTrigger) return;
    if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
    e.preventDefault();
    const dir = e.key === 'ArrowRight' ? 1 : -1;
    const step = (reelTrigger.end - reelTrigger.start) / Math.max(1, total - 1);
    const nextScroll = Math.min(reelTrigger.end, Math.max(reelTrigger.start, window.scrollY + dir * step));
    window.scrollTo({ top: nextScroll, behavior: 'smooth' });
  };

  section.addEventListener('keydown', onKeyDown);
  keyCleanup = () => section.removeEventListener('keydown', onKeyDown);
}

export function destroyProjectReel() {
  if (keyCleanup) {
    keyCleanup();
    keyCleanup = null;
  }
  if (reelTrigger) {
    reelTrigger.kill();
    reelTrigger = null;
  }
}

