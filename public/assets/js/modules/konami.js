/**
 * modules/konami.js — Konami Code (↑↑↓↓←→←→BA) Glitch Overdrive + View-Source Console Greeting
 */
import { state, notify } from '../core/state.js';
import { showToast } from '../core/utils.js';
import { playTransitionSweep } from './sound.js';

const KONAMI_SEQ = [
  'ArrowUp',
  'ArrowUp',
  'ArrowDown',
  'ArrowDown',
  'ArrowLeft',
  'ArrowRight',
  'ArrowLeft',
  'ArrowRight',
  'b',
  'a',
];

let buffer = [];

export function toggleKonamiGlitch() {
  state.glitchMode = !state.glitchMode;
  document.body.classList.toggle('glitch-overdrive', state.glitchMode);
  notify('glitch', state.glitchMode);
  playTransitionSweep();

  if (state.glitchMode) {
    showToast('⚠ INTRUDER DETECTED // GLITCH OVERDRIVE ENGAGED [ESC TO RESTORE]', 4500);
  } else {
    showToast('// SYSTEM INTEGRITY RESTORED // NORMAL TELEMETRY', 3000);
  }
}

export function initKonamiAndEasterEggs() {
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && state.glitchMode) {
      toggleKonamiGlitch();
      return;
    }

    const key = e.key.length === 1 ? e.key.toLowerCase() : e.key;
    buffer.push(key);
    if (buffer.length > KONAMI_SEQ.length) {
      buffer.shift();
    }

    if (buffer.join(',') === KONAMI_SEQ.join(',')) {
      buffer = [];
      toggleKonamiGlitch();
    }
  });

  // View-Source DevTools Console Greeting (docs/03 §10.10)
  const ascii = `
  __  __    _    ____  ____  _____ ___ ____     _    
 |  \\/  |  / \\  | __ )|  _ \\| ____|_ _|  _ \\   / \\   
 | |\\/| | / _ \\ |  _ \\| | | |  _|  | || |_) | / _ \\  
 | |  | |/ ___ \\| |_) | |_| | |___ | ||  _ < / ___ \\ 
 |_|  |_/_/   \\_\\____/|____/|_____|___|_| \\_\\_/   \\_\\
  `;
  console.log(
    `%c${ascii}\n%c// MOSTEPHA AMINE BDEIRA — https://mabdeira.dev (Lyon, France)\n%c// Stack: PHP 8.2+ · CodeIgniter 4 · Laravel · MySQL/PostgreSQL · Three.js · GSAP 3\n%c// Hiring or collaborating? → contact@mabdeira.dev (Try pressing Ctrl+K or ↑↑↓↓←→←→BA)`,
    'color:#D4FF1F;font-weight:bold;font-family:monospace;',
    'color:#EDEFF5;font-family:monospace;font-size:12px;',
    'color:#2DE2E6;font-family:monospace;font-size:11px;',
    'color:#7B5CFF;font-family:monospace;font-size:11px;'
  );
}

