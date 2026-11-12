/**
 * modules/sound.js — MP3 Background Music Player (/assets/audio/bgm.mp3) + UI Sound Effects (SFX)
 */
import { state, setSoundEnabled, setBgmEnabled } from '../core/state.js';
import { showToast } from '../core/utils.js';

let audioCtx = null;
let bgmAudio = null;
let fadeInterval = null;

const BGM_SRC = '/assets/audio/bgm.mp3';
const BGM_TARGET_VOLUME = 0.45;

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

/* =====================================================================
   1. UI SOUND EFFECTS (SFX) — Independent from Background Music
   ===================================================================== */
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

/* =====================================================================
   2. MP3 BACKGROUND MUSIC PLAYER (/assets/audio/bgm.mp3)
   ===================================================================== */
function getBgmPlayer() {
  if (!bgmAudio) {
    bgmAudio = new Audio(BGM_SRC);
    bgmAudio.loop = true;
    bgmAudio.preload = 'auto';
    bgmAudio.volume = 0;
  }
  return bgmAudio;
}

function startMp3Bgm() {
  const player = getBgmPlayer();
  if (fadeInterval) {
    clearInterval(fadeInterval);
    fadeInterval = null;
  }

  player.volume = 0.05;
  const playPromise = player.play();
  if (playPromise && typeof playPromise.catch === 'function') {
    playPromise.catch(() => {
      showToast('⚠ PLACE OR ENABLE /assets/audio/bgm.mp3');
    });
  }

  fadeInterval = window.setInterval(() => {
    if (player.volume < BGM_TARGET_VOLUME - 0.03) {
      player.volume = Math.min(BGM_TARGET_VOLUME, player.volume + 0.03);
    } else {
      player.volume = BGM_TARGET_VOLUME;
      clearInterval(fadeInterval);
      fadeInterval = null;
    }
  }, 60);
}

function stopMp3Bgm() {
  if (!bgmAudio) return;
  if (fadeInterval) {
    clearInterval(fadeInterval);
    fadeInterval = null;
  }

  fadeInterval = window.setInterval(() => {
    if (bgmAudio.volume > 0.04) {
      bgmAudio.volume = Math.max(0, bgmAudio.volume - 0.04);
    } else {
      bgmAudio.volume = 0;
      bgmAudio.pause();
      clearInterval(fadeInterval);
      fadeInterval = null;
    }
  }, 50);
}

export function syncSoundButtons() {
  // 1. Sync SFX Button
  const sfxBtn = document.getElementById('hud-sound-btn');
  const sfxLabel = document.getElementById('hud-sound-label');
  const sfxIcon = document.getElementById('hud-sound-icon');
  if (sfxBtn) {
    sfxBtn.setAttribute('aria-pressed', state.soundEnabled ? 'true' : 'false');
    sfxBtn.classList.toggle('text-[var(--acid)]', state.soundEnabled);
    sfxBtn.classList.toggle('border-[var(--acid)]/50', state.soundEnabled);
  }
  if (sfxLabel) {
    sfxLabel.textContent = state.soundEnabled ? 'SFX:ON' : 'SFX:OFF';
  }
  if (sfxIcon && window.lucide) {
    sfxIcon.setAttribute('data-lucide', state.soundEnabled ? 'volume-2' : 'volume-x');
  }

  // 2. Sync BGM Button
  const bgmBtn = document.getElementById('hud-bgm-btn');
  const bgmLabel = document.getElementById('hud-bgm-label');
  const bgmDot = document.getElementById('hud-bgm-dot');
  if (bgmBtn) {
    bgmBtn.setAttribute('aria-pressed', state.bgmEnabled ? 'true' : 'false');
    bgmBtn.classList.toggle('text-[var(--acid)]', state.bgmEnabled);
    bgmBtn.classList.toggle('border-[var(--acid)]/50', state.bgmEnabled);
  }
  if (bgmLabel) {
    bgmLabel.textContent = state.bgmEnabled ? 'BGM:ON' : 'BGM:OFF';
  }
  if (bgmDot) {
    bgmDot.classList.toggle('bg-[var(--acid)]', state.bgmEnabled);
    bgmDot.classList.toggle('animate-pulse', state.bgmEnabled);
    bgmDot.classList.toggle('bg-white/30', !state.bgmEnabled);
  }

  if (window.lucide) {
    window.lucide.createIcons();
  }
}

export function toggleSound() {
  const next = setSoundEnabled(!state.soundEnabled);
  syncSoundButtons();
  if (next) {
    playClickChirp();
    showToast('// UI SOUND EFFECTS: ENABLED');
  } else {
    showToast('// UI SOUND EFFECTS: MUTED');
  }
  return next;
}

export function toggleBgm() {
  const next = setBgmEnabled(!state.bgmEnabled);
  syncSoundButtons();
  if (next) {
    startMp3Bgm();
    showToast('♪ BGM MP3 TRACK: PLAYING');
  } else {
    stopMp3Bgm();
    showToast('♪ BGM MP3 TRACK: PAUSED');
  }
  return next;
}

export function initSoundGlobal() {
  syncSoundButtons();

  const sfxBtn = document.getElementById('hud-sound-btn');
  if (sfxBtn) {
    sfxBtn.addEventListener('click', toggleSound);
  }

  const bgmBtn = document.getElementById('hud-bgm-btn');
  if (bgmBtn) {
    bgmBtn.addEventListener('click', toggleBgm);
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
