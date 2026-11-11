/**
 * modules/preloader.js — AI-render style "Generating…" preloader (< 3.2s, once per session)
 */
import { prefersReduced } from '../core/motion-prefs.js';

const SESSION_KEY = 'nexus_preloader_seen';

export function initPreloader(onComplete) {
  const preloader = document.getElementById('nexus-preloader');
  if (!preloader) {
    if (onComplete) onComplete();
    return;
  }

  let alreadySeen = false;
  try {
    alreadySeen = sessionStorage.getItem(SESSION_KEY) === '1';
  } catch (_) {}

  if (prefersReduced() || alreadySeen) {
    preloader.style.opacity = '0';
    preloader.style.display = 'none';
    if (onComplete) onComplete();
    return;
  }

  try {
    sessionStorage.setItem(SESSION_KEY, '1');
  } catch (_) {}

  const counterEl = document.getElementById('preloader-counter');
  const barEl = document.getElementById('preloader-bar');
  const statusEl = document.getElementById('preloader-status');
  const resBadge = document.getElementById('preloader-res-badge');
  const topPanel = document.getElementById('preloader-panel-top');
  const bottomPanel = document.getElementById('preloader-panel-bottom');
  const stage = document.getElementById('preloader-stage');
  const canvas = document.getElementById('preloader-canvas');

  // Render resolving pixelation noise square (uPixel 64 -> 1)
  const ctx = canvas ? canvas.getContext('2d') : null;
  function drawPixelNoise(progress) {
    if (!ctx) return;
    const w = canvas.width;
    const h = canvas.height;
    const blockSize = Math.max(1, Math.round(32 * Math.pow(1 - progress, 1.8)));
    if (resBadge) {
      const dim = Math.min(128, Math.max(4, Math.round(128 / blockSize)));
      resBadge.textContent = `${dim}x${dim}`;
    }

    ctx.fillStyle = '#05060A';
    ctx.fillRect(0, 0, w, h);

    for (let y = 0; y < h; y += blockSize) {
      for (let x = 0; x < w; x += blockSize) {
        const nx = x / w - 0.5;
        const ny = y / h - 0.5;
        const dist = Math.sqrt(nx * nx + ny * ny);
        const wave = Math.sin(dist * 16 - progress * 8) * 0.5 + 0.5;
        const jitter = (Math.random() - 0.5) * (1 - progress) * 0.65;
        const val = Math.max(0, Math.min(1, wave + jitter));

        if (val > 0.62) {
          ctx.fillStyle = `rgba(212, 255, 31, ${0.25 + val * 0.65})`;
        } else if (val > 0.38) {
          ctx.fillStyle = `rgba(123, 92, 255, ${0.2 + val * 0.5})`;
        } else {
          ctx.fillStyle = `rgba(45, 226, 230, ${val * 0.35})`;
        }
        ctx.fillRect(x, y, blockSize, blockSize);
      }
    }
  }

  if (!window.gsap) {
    preloader.style.display = 'none';
    if (onComplete) onComplete();
    return;
  }

  const gsap = window.gsap;
  const proxy = { val: 0 };

  const tl = gsap.timeline({
    onComplete: () => {
      preloader.style.display = 'none';
      if (onComplete) onComplete();
    },
  });

  if (statusEl && window.ScrambleTextPlugin) {
    gsap.to(statusEl, {
      duration: 1.5,
      scrambleText: {
        text: '> RENDER COMPLETE // SCENE 01 READY',
        chars: '01/#X$<>_',
        speed: 0.4,
      },
      delay: 0.5,
    });
  }

  tl.to(proxy, {
    val: 100,
    duration: 1.75,
    ease: 'expo.inOut',
    onUpdate: () => {
      const v = Math.round(proxy.val);
      if (counterEl) counterEl.textContent = String(v).padStart(3, '0');
      if (barEl) barEl.style.width = `${v}%`;
      drawPixelNoise(proxy.val / 100);
    },
  })
    .to(
      stage,
      {
        scale: 0.82,
        opacity: 0,
        duration: 0.4,
        ease: 'power3.in',
      },
      '+=0.08'
    )
    .to(
      topPanel,
      {
        yPercent: -100,
        duration: 0.65,
        ease: 'expo.inOut',
      },
      '-=0.15'
    )
    .to(
      bottomPanel,
      {
        yPercent: 100,
        duration: 0.65,
        ease: 'expo.inOut',
      },
      '<'
    );
}
