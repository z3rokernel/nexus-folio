/**
 * modules/github-stats.js — Live /api/github Contribution Heat-Grid with Cursor Wave
 */
import { state, THEME_COLORS } from '../core/state.js';

let rafId = null;
let cleanupFn = null;

export async function initGitHubStats(container = document) {
  destroyGitHubStats();

  const canvas = container.querySelector('#github-heatgrid-canvas');
  const badge = container.querySelector('#gh-total-badge');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  let weeks = [];
  try {
    const res = await fetch('/api/github', { headers: { Accept: 'application/json' } });
    if (res.ok) {
      const json = await res.json();
      weeks = json.weeks || [];
      if (badge && json.total_contributions) {
        badge.textContent = `${Number(json.total_contributions).toLocaleString()} CONTRIBUTIONS`;
      }
    }
  } catch (_) {}

  if (weeks.length === 0) {
    for (let w = 0; w < 52; w++) {
      const col = [];
      for (let d = 0; d < 7; d++) {
        col.push({ level: (w + d) % 5, count: (w + d) % 9 });
      }
      weeks.push(col);
    }
  }

  let mouseX = -999;
  let mouseY = -999;

  const onMove = (e) => {
    const rect = canvas.getBoundingClientRect();
    mouseX = ((e.clientX - rect.left) / rect.width) * canvas.width;
    mouseY = ((e.clientY - rect.top) / rect.height) * canvas.height;
  };
  const onLeave = () => {
    mouseX = -999;
    mouseY = -999;
  };

  canvas.addEventListener('pointermove', onMove);
  canvas.addEventListener('pointerleave', onLeave);

  const startTime = performance.now();

  function draw(now) {
    const elapsed = (now - startTime) * 0.001;
    const w = canvas.width;
    const h = canvas.height;
    ctx.clearRect(0, 0, w, h);

    const cols = weeks.length;
    const rows = 7;
    const padX = 20;
    const padY = 18;
    const cellW = (w - padX * 2) / cols;
    const cellH = (h - padY * 2) / rows;
    const size = Math.min(cellW, cellH) - 4;

    const rgb = (THEME_COLORS[state.theme] || THEME_COLORS.acid).rgb;
    const r = Math.round(rgb[0] * 255);
    const g = Math.round(rgb[1] * 255);
    const b = Math.round(rgb[2] * 255);

    for (let c = 0; c < cols; c++) {
      for (let row = 0; row < rows; row++) {
        const cell = weeks[c][row] || { level: 0 };
        const cx = padX + c * cellW;
        const cy = padY + row * cellH;

        const revealWave = Math.min(1, Math.max(0, (elapsed * 28 - c) * 0.25));
        const dist = Math.hypot(cx - mouseX, cy - mouseY);
        const hoverBoost = dist < 110 ? (1 - dist / 110) * 0.45 : 0;

        const baseAlpha =
          cell.level === 0
            ? 0.08
            : cell.level === 1
            ? 0.28
            : cell.level === 2
            ? 0.52
            : cell.level === 3
            ? 0.78
            : 1.0;

        const alpha = Math.min(1, (baseAlpha + hoverBoost) * revealWave);
        ctx.fillStyle = cell.level === 0 && hoverBoost === 0 ? `rgba(255,255,255,${0.06 * revealWave})` : `rgba(${r},${g},${b},${alpha})`;

        const scale = 1 + hoverBoost * 0.35;
        const drawSize = size * scale;
        ctx.beginPath();
        ctx.roundRect(cx - (drawSize - size) / 2, cy - (drawSize - size) / 2, drawSize, drawSize, 3);
        ctx.fill();
      }
    }

    rafId = requestAnimationFrame(draw);
  }

  rafId = requestAnimationFrame(draw);

  cleanupFn = () => {
    canvas.removeEventListener('pointermove', onMove);
    canvas.removeEventListener('pointerleave', onLeave);
  };
}

export function destroyGitHubStats() {
  if (rafId) {
    cancelAnimationFrame(rafId);
    rafId = null;
  }
  if (cleanupFn) {
    cleanupFn();
    cleanupFn = null;
  }
}

