/**
 * modules/hud.js — HUD Telemetry, Live Clock, Menu Overlay, Theme Switcher, Scroll Progress & Idle Mode
 */
import { state, cycleTheme, setTheme } from '../core/state.js';
import { prefersReduced, toggleReducedMotion } from '../core/motion-prefs.js';
import { copyToClipboard, showToast } from '../core/utils.js';
import { scrollToTop, stopScroll, startScroll } from '../core/lenis.js';

let sceneTriggers = [];
let idleTimer = null;

export function initHudGlobal() {
  // 1. Live Clock (Europe/Paris or local)
  const clockEl = document.getElementById('hud-clock');
  const dotEl = document.getElementById('hud-daynight-dot');

  function updateClock() {
    if (!clockEl) return;
    const now = new Date();
    const formatted = now.toLocaleTimeString('en-GB', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      timeZone: 'Europe/Paris',
    });
    clockEl.textContent = `${formatted} CET`;
    const hour = now.getHours();
    if (dotEl) {
      const isNight = hour < 7 || hour >= 20;
      dotEl.style.backgroundColor = isNight ? '#7B5CFF' : '#2DE2E6';
    }
  }
  updateClock();
  setInterval(updateClock, 1000);

  // 2. Scroll Progress Indicator
  function updateScrollHud() {
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const pct = docHeight > 0 ? Math.min(100, Math.max(0, Math.round((window.scrollY / docHeight) * 100))) : 0;
    const pctEl = document.getElementById('hud-scroll-pct');
    const barEl = document.getElementById('hud-scroll-bar');
    const hintEl = document.getElementById('hud-scroll-hint');

    if (pctEl) pctEl.textContent = `${String(pct).padStart(3, '0')}%`;
    if (barEl) barEl.style.width = `${pct}%`;
    if (hintEl) {
      hintEl.style.opacity = window.scrollY > 80 ? '0' : '1';
    }
  }
  window.addEventListener('scroll', updateScrollHud, { passive: true });
  updateScrollHud();

  // 3. Theme Cycle Button & Theme Buttons inside Menu
  const themeBtn = document.getElementById('hud-theme-btn');
  if (themeBtn) {
    themeBtn.addEventListener('click', () => {
      const next = cycleTheme();
      showToast(`// THEME ACCENT SWITCHED TO: ${next.toUpperCase()}`);
    });
  }

  document.querySelectorAll('[data-set-theme]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const targetTheme = btn.getAttribute('data-set-theme');
      if (targetTheme) {
        setTheme(targetTheme);
        showToast(`// THEME ACCENT SWITCHED TO: ${targetTheme.toUpperCase()}`);
      }
    });
  });

  // 4. Reduced Motion Toggle in Menu Overlay
  const rmBtn = document.getElementById('menu-reduced-motion-toggle');
  const rmStateLabel = document.getElementById('menu-reduced-motion-state');
  function syncRmLabel() {
    const isRm = prefersReduced();
    if (rmBtn) rmBtn.setAttribute('aria-pressed', isRm ? 'true' : 'false');
    if (rmStateLabel) {
      rmStateLabel.textContent = isRm ? 'ON (REDUCED MOTION)' : 'OFF (FULL MOTION)';
    }
  }
  syncRmLabel();
  if (rmBtn) {
    rmBtn.addEventListener('click', () => {
      const enabled = toggleReducedMotion();
      syncRmLabel();
      showToast(enabled ? '// ACCESSIBILITY: REDUCED MOTION ON' : '// CINEMA MOTION RESTORED');
    });
  }

  // 5. Full-Screen Menu Overlay Toggle
  const menuBtn = document.getElementById('menu-toggle-btn');
  const menuOverlay = document.getElementById('nexus-menu-overlay');
  const menuLabel = document.getElementById('menu-toggle-label');
  const previewImg = document.getElementById('menu-preview-img');
  const previewCaption = document.getElementById('menu-preview-caption');

  if (menuBtn && menuOverlay) {
    menuBtn.addEventListener('click', () => {
      toggleMenuOverlay(!state.menuOpen);
    });
  }

  document.querySelectorAll('[data-menu-link]').forEach((link) => {
    link.addEventListener('pointerenter', () => {
      const src = link.getAttribute('data-preview');
      const sub = link.getAttribute('data-sub');
      if (previewImg && src) previewImg.src = src;
      if (previewCaption && sub) previewCaption.textContent = `SCENE PREVIEW // ${sub.toUpperCase()}`;
    });
    link.addEventListener('click', () => {
      toggleMenuOverlay(false);
    });
  });

  // 6. Delegated Copy-Email & Back-to-Top handlers
  document.addEventListener('click', (e) => {
    const copyBtn = e.target.closest && e.target.closest('[data-copy-email]');
    if (copyBtn) {
      e.preventDefault();
      const email = copyBtn.getAttribute('data-copy-email') || 'contact@nexus-folio.dev';
      copyToClipboard(email, 'COORDINATES COPIED');
      return;
    }

    const topBtn = e.target.closest && e.target.closest('#footer-back-to-top');
    if (topBtn) {
      e.preventDefault();
      scrollToTop();
    }
  });

  // 7. 20s Idle Breathing Mode (> still there?)
  const idleToast = document.getElementById('idle-toast');
  function resetIdleTimer() {
    if (idleToast && idleToast.style.opacity === '1') {
      idleToast.style.opacity = '0';
    }
    clearTimeout(idleTimer);
    idleTimer = setTimeout(() => {
      if (idleToast && !state.menuOpen && !state.paletteOpen) {
        idleToast.style.opacity = '1';
      }
    }, 20000);
  }

  ['pointermove', 'keydown', 'scroll', 'touchstart'].forEach((evt) => {
    window.addEventListener(evt, resetIdleTimer, { passive: true });
  });
  resetIdleTimer();

  // Esc key closes menu
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && state.menuOpen) {
      toggleMenuOverlay(false);
    }
  });
}

export function toggleMenuOverlay(open) {
  const menuOverlay = document.getElementById('nexus-menu-overlay');
  const menuBtn = document.getElementById('menu-toggle-btn');
  const menuLabel = document.getElementById('menu-toggle-label');
  if (!menuOverlay || !menuBtn) return;

  state.menuOpen = Boolean(open);
  menuBtn.setAttribute('aria-expanded', state.menuOpen ? 'true' : 'false');
  menuOverlay.setAttribute('aria-hidden', state.menuOpen ? 'false' : 'true');
  if (menuLabel) menuLabel.textContent = state.menuOpen ? 'CLOSE' : 'MENU';

  if (state.menuOpen) {
    stopScroll();
    menuOverlay.classList.remove('pointer-events-none');
    menuOverlay.style.opacity = '1';
    menuOverlay.style.clipPath = 'circle(150% at 94% 4%)';
  } else {
    startScroll();
    menuOverlay.classList.add('pointer-events-none');
    menuOverlay.style.opacity = '0';
    menuOverlay.style.clipPath = 'circle(0% at 94% 4%)';
  }
}

export function initHudPage(container = document) {
  destroyHudPage();
  const scenes = Array.from(container.querySelectorAll('[data-scene]'));
  const total = String(Math.max(1, scenes.length)).padStart(2, '0');
  const indexEl = document.getElementById('hud-scene-index');
  if (indexEl) {
    indexEl.textContent = `01 / ${total}`;
  }

  if (!window.ScrollTrigger) return;

  scenes.forEach((sec, idx) => {
    const num = sec.getAttribute('data-scene') || String(idx + 1).padStart(2, '0');
    const st = window.ScrollTrigger.create({
      trigger: sec,
      start: 'top 55%',
      end: 'bottom 45%',
      onToggle: (self) => {
        if (self.isActive && indexEl) {
          indexEl.textContent = `${num} / ${total}`;
        }
      },
    });
    sceneTriggers.push(st);
  });
}

export function destroyHudPage() {
  sceneTriggers.forEach((st) => st.kill());
  sceneTriggers = [];
}

