/**
 * core/state.js — Centralized Reactive Studio State
 */

const THEME_KEY = 'nexus_theme';
const SOUND_KEY = 'nexus_sound';

export const THEMES = ['acid', 'plasma', 'cyan'];

export const THEME_COLORS = {
  acid:   { hex: '#D4FF1F', rgb: [0.831, 1.0, 0.122] },
  plasma: { hex: '#7B5CFF', rgb: [0.482, 0.361, 1.0] },
  cyan:   { hex: '#2DE2E6', rgb: [0.176, 0.886, 0.902] },
};

export const state = {
  theme: 'acid',
  soundEnabled: false,
  glitchMode: false,
  menuOpen: false,
  paletteOpen: false,
  scrollProgress: 0,
  scrollVelocity: 0,
  scrollDirection: 1,
  activeScene: '01',
  totalScenes: '09',
  mouse: { x: 0.5, y: 0.5, px: 0, py: 0, vx: 0, vy: 0 },
};

const subscribers = new Set();

export function initState() {
  try {
    const savedTheme = localStorage.getItem(THEME_KEY);
    if (savedTheme && THEMES.includes(savedTheme)) {
      state.theme = savedTheme;
    }
    const savedSound = localStorage.getItem(SOUND_KEY);
    state.soundEnabled = savedSound === '1';
  } catch (_) {}

  applyThemeToDom(state.theme);
}

export function setTheme(themeName) {
  if (!THEMES.includes(themeName)) return state.theme;
  state.theme = themeName;
  try {
    localStorage.setItem(THEME_KEY, themeName);
  } catch (_) {}
  applyThemeToDom(themeName);
  notify('theme', themeName);
  return themeName;
}

export function cycleTheme() {
  const idx = THEMES.indexOf(state.theme);
  const next = THEMES[(idx + 1) % THEMES.length];
  return setTheme(next);
}

function applyThemeToDom(themeName) {
  document.documentElement.setAttribute('data-theme', themeName);
  const label = document.getElementById('hud-theme-label');
  if (label) {
    label.textContent = themeName.toUpperCase();
  }
}

export function setSoundEnabled(enabled) {
  state.soundEnabled = Boolean(enabled);
  try {
    localStorage.setItem(SOUND_KEY, state.soundEnabled ? '1' : '0');
  } catch (_) {}
  notify('sound', state.soundEnabled);
  return state.soundEnabled;
}

export function subscribeState(fn) {
  subscribers.add(fn);
  return () => subscribers.delete(fn);
}

export function notify(key, value) {
  subscribers.forEach((fn) => {
    try {
      fn(key, value, state);
    } catch (_) {}
  });
}

