/**
 * modules/sound.js — Independent Background Music (Ambient Synth Score) + UI Sound Effects
 */
import { state, setSoundEnabled, setBgmEnabled } from '../core/state.js';
import { showToast } from '../core/utils.js';

let audioCtx = null;
let bgmNodes = null;
let bgmArpTimer = null;

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
   2. CINEMATIC AMBIENT BACKGROUND MUSIC (BGM) — Independent Toggle
   ===================================================================== */
function startAmbientBgm() {
  const ctx = ensureContext();
  if (!ctx || bgmNodes) return;

  const now = ctx.currentTime;

  // Master BGM bus with smooth fade-in
  const masterGain = ctx.createGain();
  masterGain.gain.setValueAtTime(0.0001, now);
  masterGain.gain.linearRampToValueAtTime(0.14, now + 1.8);
  masterGain.connect(ctx.destination);

  // Warm Lowpass Filter modulated by a slow LFO
  const filter = ctx.createBiquadFilter();
  filter.type = 'lowpass';
  filter.frequency.setValueAtTime(420, now);
  filter.Q.setValueAtTime(2.2, now);
  filter.connect(masterGain);

  const lfo = ctx.createOscillator();
  const lfoGain = ctx.createGain();
  lfo.type = 'sine';
  lfo.frequency.setValueAtTime(0.08, now); // 12.5s breathing cycle
  lfoGain.gain.setValueAtTime(240, now);
  lfo.connect(lfoGain);
  lfoGain.connect(filter.frequency);
  lfo.start(now);

  // Stereo-like Delay Echo for Arpeggiator
  const delay = ctx.createDelay(1.0);
  delay.delayTime.setValueAtTime(0.375, now);
  const delayFeedback = ctx.createGain();
  delayFeedback.gain.setValueAtTime(0.42, now);
  const delayFilter = ctx.createBiquadFilter();
  delayFilter.type = 'lowpass';
  delayFilter.frequency.setValueAtTime(1100, now);

  delay.connect(delayFilter);
  delayFilter.connect(delayFeedback);
  delayFeedback.connect(delay);
  delay.connect(masterGain);

  // Deep Sub & Pad Oscillators (A minor 9th atmospheric chord: A1, E2, A2, C3, E3, B3)
  const padFreqs = [
    { freq: 55.0, type: 'sawtooth', detune: -4, vol: 0.32 },
    { freq: 82.41, type: 'sawtooth', detune: 5, vol: 0.22 },
    { freq: 110.0, type: 'triangle', detune: -7, vol: 0.20 },
    { freq: 130.81, type: 'sine', detune: 3, vol: 0.16 },
    { freq: 164.81, type: 'triangle', detune: 6, vol: 0.14 },
    { freq: 246.94, type: 'sine', detune: -5, vol: 0.10 },
  ];

  const oscList = padFreqs.map((cfg) => {
    const osc = ctx.createOscillator();
    const g = ctx.createGain();
    osc.type = cfg.type;
    osc.frequency.setValueAtTime(cfg.freq, now);
    osc.detune.setValueAtTime(cfg.detune, now);
    g.gain.setValueAtTime(cfg.vol, now);
    osc.connect(g);
    g.connect(filter);
    osc.start(now);
    return osc;
  });

  // Gentle Sci-Fi Arpeggiator Sequence
  const arpNotes = [220.0, 261.63, 329.63, 392.0, 493.88, 392.0, 329.63, 246.94];
  let step = 0;

  bgmArpTimer = window.setInterval(() => {
    if (!state.bgmEnabled || !audioCtx || audioCtx.state !== 'running') return;
    const t = audioCtx.currentTime;
    const note = arpNotes[step % arpNotes.length];
    step += 1;

    const arpOsc = audioCtx.createOscillator();
    const arpGain = audioCtx.createGain();
    arpOsc.type = 'sine';
    arpOsc.frequency.setValueAtTime(note, t);

    arpGain.gain.setValueAtTime(0.0001, t);
    arpGain.gain.linearRampToValueAtTime(0.045, t + 0.04);
    arpGain.gain.exponentialRampToValueAtTime(0.0001, t + 0.45);

    arpOsc.connect(arpGain);
    arpGain.connect(filter);
    arpGain.connect(delay);

    arpOsc.start(t);
    arpOsc.stop(t + 0.48);
  }, 500);

  bgmNodes = { masterGain, oscList, lfo };
}

function stopAmbientBgm() {
  if (bgmArpTimer) {
    clearInterval(bgmArpTimer);
    bgmArpTimer = null;
  }
  if (!bgmNodes || !audioCtx) {
    bgmNodes = null;
    return;
  }

  const now = audioCtx.currentTime;
  const { masterGain, oscList, lfo } = bgmNodes;
  bgmNodes = null;

  try {
    masterGain.gain.cancelScheduledValues(now);
    masterGain.gain.setValueAtTime(Math.max(masterGain.gain.value, 0.0001), now);
    masterGain.gain.exponentialRampToValueAtTime(0.0001, now + 0.6);
    setTimeout(() => {
      oscList.forEach((o) => {
        try { o.stop(); } catch (_) {}
      });
      try { lfo.stop(); } catch (_) {}
    }, 650);
  } catch (_) {}
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
    startAmbientBgm();
    showToast('♪ AMBIENT SYNTH BGM: PLAYING');
  } else {
    stopAmbientBgm();
    showToast('♪ AMBIENT SYNTH BGM: PAUSED');
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
