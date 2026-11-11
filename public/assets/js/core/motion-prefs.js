/**
 * core/motion-prefs.js — Reduced-motion preference manager + Motion tokens
 */

export const EASE = {
  out: 'expo.out',
  inOut: 'power4.inOut',
  soft: 'power3.out',
  spring: 'elastic.out(1, 0.4)',
};

export const DUR = {
  xs: 0.2,
  sm: 0.45,
  md: 0.8,
  lg: 1.2,
  xl: 1.8,
};

export const STAGGER = {
  chars: 0.025,
  words: 0.06,
  lines: 0.12,
  cards: 0.1,
};

const STORAGE_KEY = 'nexus_reduced_motion';
const listeners = new Set();

export function prefersReduced() {
  try {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored === '1') return true;
    if (stored === '0') return false;
  } catch (_) {}

  return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

export function setReducedMotion(enabled) {
  const bool = Boolean(enabled);
  try {
    localStorage.setItem(STORAGE_KEY, bool ? '1' : '0');
  } catch (_) {}

  document.documentElement.classList.toggle('reduced-motion', bool);
  document.body.classList.toggle('reduced-motion', bool);

  listeners.forEach((fn) => {
    try {
      fn(bool);
    } catch (_) {}
  });

  return bool;
}

export function toggleReducedMotion() {
  return setReducedMotion(!prefersReduced());
}

export function onMotionPrefChange(callback) {
  listeners.add(callback);
  return () => listeners.delete(callback);
}

// Sync initial class on load
if (typeof window !== 'undefined') {
  const initial = prefersReduced();
  document.documentElement.classList.toggle('reduced-motion', initial);
  if (document.body) {
    document.body.classList.toggle('reduced-motion', initial);
  }
}
