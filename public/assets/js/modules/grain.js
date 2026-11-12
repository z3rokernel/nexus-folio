/**
 * modules/grain.js — Animated Film Grain Overlay (Opacity 0.055, mix-blend-mode: overlay)
 */
import { prefersReduced } from '../core/motion-prefs.js';

export function initGrain() {
  const canvas = document.getElementById('film-grain');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const size = 160;
  canvas.width = size;
  canvas.height = size;

  function drawNoise() {
    const imgData = ctx.createImageData(size, size);
    const buf = imgData.data;
    for (let i = 0; i < buf.length; i += 4) {
      const val = (Math.random() * 255) | 0;
      buf[i] = val;
      buf[i + 1] = val;
      buf[i + 2] = val;
      buf[i + 3] = 28;
    }
    ctx.putImageData(imgData, 0, 0);
  }

  drawNoise();

  setInterval(() => {
    if (!document.hidden && !prefersReduced()) {
      drawNoise();
    }
  }, 110);
}

