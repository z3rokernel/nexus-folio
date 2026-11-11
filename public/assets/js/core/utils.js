/**
 * core/utils.js — Math, WebGL Detection, Toast & A11y Helpers
 */

export const lerp = (a, b, t) => a + (b - a) * t;
export const clamp = (val, min, max) => Math.max(min, Math.min(max, val));
export const mapRange = (val, inMin, inMax, outMin, outMax) =>
  outMin + ((clamp(val, inMin, inMax) - inMin) * (outMax - outMin)) / (inMax - inMin || 1);

export function isTouchDevice() {
  return (
    'ontouchstart' in window ||
    navigator.maxTouchPoints > 0 ||
    window.matchMedia('(pointer: coarse)').matches
  );
}

export function checkWebGLSupport() {
  try {
    const canvas = document.createElement('canvas');
    const gl = canvas.getContext('webgl2') || canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
    const supported = Boolean(gl);
    if (!supported) {
      document.documentElement.classList.add('no-webgl');
    }
    return supported;
  } catch (_) {
    document.documentElement.classList.add('no-webgl');
    return false;
  }
}

let toastTimer = null;
export function showToast(message, duration = 2800) {
  const toast = document.getElementById('nexus-toast');
  const text = document.getElementById('nexus-toast-text');
  if (!toast || !text) return;

  text.textContent = message;
  toast.style.opacity = '1';
  toast.style.transform = 'translateY(0)';

  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-10px)';
  }, duration);
}

export function announceA11y(message) {
  const region = document.getElementById('a11y-announcer');
  if (!region) return;
  region.textContent = '';
  setTimeout(() => {
    region.textContent = message;
  }, 50);
}

export async function copyToClipboard(text, label = 'EMAIL COPIED TO CLIPBOARD') {
  try {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      await navigator.clipboard.writeText(text);
    } else {
      const ta = document.createElement('textarea');
      ta.value = text;
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      ta.remove();
    }
    showToast(`// ${label}: ${text}`);
    return true;
  } catch (_) {
    showToast(`//ADDRESS: ${text}`);
    return false;
  }
}
