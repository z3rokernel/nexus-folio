/**
 * modules/sound.js — Synthesized Sci-Fi Studio UI Audio (Default OFF, Opt-In)
 */
import { state, setSoundEnabled } from '../core/state.js';
import { showToast } from '../core/utils.js';

let audioCtx = null;

function ensureContext() {
  if (!audioCtx && (window.AudioContext || window.webkitAudioContext)) {
    const Ctx = window.AudioContext || window.webkitAudioContext;
    audioCtx = new Ctx();
  }
  if (audioCtx && audioCtx.state === 'suspended') {
    audioCtx.resume().catch(() => {});
  }
  return audioCtx;
}

export function playHoverTick() {
  if (!state.soundEnabled) return;
  const ctx = ensureContext();
  if (!ctx) return;

  const now = ctx.currentTime;
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();
  osc.type = 'sine';
  osc.frequency.setValueAtTime(1480, now);
  osc.frequency.exponentialRampToValueAtTime(640, now + 0.035);

  gain.gain.setValueAtTime(0.035, now);
  gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.035);

  osc.connect(gain);
  gain.connect(ctx.destination);
  osc.start(now);
  osc.stop(now + 0.04);
}

export function playClickChirp() {
  if (!state.soundEnabled) return;
  const ctx = ensureContext();
  if (!ctx) return;

  const now = ctx.currentTime;
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();
  osc.type = 'triangle';
  osc.frequency.setValueAtTime(520, now);
  osc.frequency.exponentialRampToValueAtTime(1240, now + 0.065);

  gain.gain.setValueAtTime(0.06, now);
  gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.07);

  osc.connect(gain);
  gain.connect(ctx.destination);
  osc.start(now);
  osc.stop(now + 0.075);
}

export function playTransitionSweep() {
  if (!state.soundEnabled) return;
  const ctx = ensureContext();
  if (!ctx) return;

  const now = ctx.currentTime;
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();
  osc.type = 'sine';
  osc.frequency.setValueAtTime(140, now);
  osc.frequency.exponentialRampToValueAtTime(420, now + 0.25);
  osc.frequency.exponentialRampToValueAtTime(90, now + 0.55);

  gain.gain.setValueAtTime(0.05, now);
  gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.55);

  osc.connect(gain);
  gain.connect(ctx.destination);
  osc.start(now);
  osc.stop(now + 0.56);
}

export function syncSoundButtons() {
  const btn = document.getElementById('hud-sound-btn');
  const label = document.getElementById('hud-sound-label');
  const icon = document.getElementById('hud-sound-icon');
  if (btn) {
    btn.setAttribute('aria-pressed', state.soundEnabled ? 'true' : 'false');
    btn.classList.toggle('text-[var(--acid)]', state.soundEnabled);
  }
  if (label) {
    label.textContent = state.soundEnabled ? 'SFX:ON' : 'SFX:OFF';
  }
  if (icon && window.lucide) {
    icon.setAttribute('data-lucide', state.soundEnabled ? 'volume-2' : 'volume-x');
    window.lucide.createIcons();
  }
}

export function toggleSound() {
  const next = setSoundEnabled(!state.soundEnabled);
  syncSoundButtons();
  if (next) {
    playClickChirp();
    showToast('// STUDIO AUDIO TELEMETRY: ENABLED');
  } else {
    showToast('// STUDIO AUDIO TELEMETRY: MUTED');
  }
  return next;
}

export function initSoundGlobal() {
  syncSoundButtons();
  const btn = document.getElementById('hud-sound-btn');
  if (btn) {
    btn.addEventListener('click', toggleSound);
  }

  document.addEventListener(
    'pointerenter',
    (e) => {
      if (!state.soundEnabled) return;
      const target = e.target;
      if (target && target.closest && target.closest('a, button, [data-magnetic]')) {
        playHoverTick();
      }
    },
    true
  );

  document.addEventListener(
    'click',
    (e) => {
      if (!state.soundEnabled) return;
      const target = e.target;
      if (target && target.closest && target.closest('a, button')) {
        playClickChirp();
      }
    },
    true
  );
}
