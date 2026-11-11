/**
 * modules/command-palette.js — Ctrl/⌘+K Glass Modal, Fuzzy Search, Arrow Keys & GSAP Flip
 */
import { state, cycleTheme } from '../core/state.js';
import { prefersReduced, toggleReducedMotion } from '../core/motion-prefs.js';
import { copyToClipboard, showToast } from '../core/utils.js';
import { stopScroll, startScroll } from '../core/lenis.js';
import { toggleSound } from './sound.js';
import { toggleKonamiGlitch } from './konami.js';
import { navigateToUrl } from '../core/barba.js';

let activeIndex = 0;

export function initCommandPalette() {
  const backdrop = document.getElementById('command-palette-backdrop');
  const dialog = document.getElementById('command-palette-dialog');
  const input = document.getElementById('command-palette-input');
  const list = document.getElementById('command-palette-list');
  const triggerBtn = document.getElementById('cmd-palette-trigger');

  if (!backdrop || !dialog || !input || !list) return;

  const allItems = Array.from(list.querySelectorAll('[data-cmd-item]'));

  function getVisibleItems() {
    return allItems.filter((item) => item.style.display !== 'none');
  }

  function highlightItem(index) {
    const visible = getVisibleItems();
    if (visible.length === 0) return;
    activeIndex = (index + visible.length) % visible.length;
    visible.forEach((item, idx) => {
      const isSelected = idx === activeIndex;
      item.classList.toggle('bg-white/10', isSelected);
      item.classList.toggle('border-l-2', isSelected);
      item.classList.toggle('border-[var(--acid)]', isSelected);
      if (isSelected) {
        item.scrollIntoView({ block: 'nearest' });
      }
    });
  }

  function filterItems(query) {
    const q = query.trim().toLowerCase();
    const flipState = !prefersReduced() && window.Flip ? window.Flip.getState(allItems) : null;

    allItems.forEach((item) => {
      const text = (item.textContent || '').toLowerCase();
      const kw = (item.getAttribute('data-keywords') || '').toLowerCase();
      const match = !q || text.includes(q) || kw.includes(q);
      item.style.display = match ? '' : 'none';
    });

    highlightItem(0);

    if (flipState && window.Flip) {
      window.Flip.from(flipState, {
        duration: 0.25,
        ease: 'power2.out',
      });
    }
  }

  function executeItem(item) {
    if (!item) return;
    const type = item.getAttribute('data-type');
    closeCommandPalette();

    if (type === 'nav') {
      const href = item.getAttribute('data-href');
      if (href) navigateToUrl(href);
      return;
    }

    const action = item.getAttribute('data-action');
    if (action === 'copy-email') {
      const email = item.getAttribute('data-email') || 'contact@nexus-folio.dev';
      copyToClipboard(email, 'EMAIL COPIED');
    } else if (action === 'download-cv') {
      const href = item.getAttribute('data-href') || '/cv.pdf';
      window.open(href, '_blank');
    } else if (action === 'cycle-theme') {
      const next = cycleTheme();
      showToast(`// THEME SWITCHED TO: ${next.toUpperCase()}`);
    } else if (action === 'toggle-sound') {
      toggleSound();
    } else if (action === 'toggle-motion') {
      const rm = toggleReducedMotion();
      showToast(rm ? '// REDUCED MOTION: ENABLED' : '// FULL MOTION: ENABLED');
    } else if (action === 'konami-glitch') {
      toggleKonamiGlitch();
    }
  }

  exportOpenClose(backdrop, dialog, input, filterItems, highlightItem);

  if (triggerBtn) {
    triggerBtn.addEventListener('click', () => openCommandPalette());
  }

  backdrop.addEventListener('click', (e) => {
    if (e.target === backdrop) closeCommandPalette();
  });

  input.addEventListener('input', () => {
    filterItems(input.value);
  });

  allItems.forEach((item) => {
    item.addEventListener('click', () => executeItem(item));
  });

  window.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      if (state.paletteOpen) closeCommandPalette();
      else openCommandPalette();
      return;
    }

    if (!state.paletteOpen) return;

    if (e.key === 'Escape') {
      e.preventDefault();
      closeCommandPalette();
    } else if (e.key === 'ArrowDown') {
      e.preventDefault();
      highlightItem(activeIndex + 1);
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      highlightItem(activeIndex - 1);
    } else if (e.key === 'Enter') {
      e.preventDefault();
      const visible = getVisibleItems();
      if (visible[activeIndex]) {
        executeItem(visible[activeIndex]);
      }
    }
  });
}

let openFn = null;
let closeFn = null;

function exportOpenClose(backdrop, dialog, input, filterItems, highlightItem) {
  openFn = () => {
    state.paletteOpen = true;
    stopScroll();
    backdrop.classList.remove('pointer-events-none');
    backdrop.style.opacity = '1';
    backdrop.setAttribute('aria-hidden', 'false');
    dialog.style.transform = 'scale(1)';
    input.value = '';
    filterItems('');
    highlightItem(0);
    setTimeout(() => input.focus(), 40);
  };

  closeFn = () => {
    state.paletteOpen = false;
    startScroll();
    backdrop.classList.add('pointer-events-none');
    backdrop.style.opacity = '0';
    backdrop.setAttribute('aria-hidden', 'true');
    dialog.style.transform = 'scale(0.95)';
  };
}

export function openCommandPalette() {
  if (openFn) openFn();
}

export function closeCommandPalette() {
  if (closeFn) closeFn();
}
