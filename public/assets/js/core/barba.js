/**
 * core/barba.js — Barba.js v2.10.3 Page Transition Orchestrator & Module Lifecycle Manager
 */
import { announceA11y } from './utils.js';
import { resetCursorState } from '../modules/cursor.js';
import { toggleMenuOverlay, initHudPage, destroyHudPage } from '../modules/hud.js';
import { playLeaveTransition, playEnterTransition } from '../modules/transitions.js';
import { initMagnetic, destroyMagnetic } from '../modules/magnetic.js';
import { initSplitReveal, destroySplitReveal } from '../modules/split-reveal.js';
import { initScramble, destroyScramble } from '../modules/scramble.js';
import { initProjectReel, destroyProjectReel } from '../modules/project-reel.js';
import { initMarquee, destroyMarquee } from '../modules/marquee.js';
import { initTiltCards, destroyTiltCards } from '../modules/tilt-cards.js';
import { initImageDistort, destroyImageDistort } from '../modules/image-distort.js';
import { initSkillsPhysics, destroySkillsPhysics } from '../modules/skills-physics.js';
import { initGitHubStats, destroyGitHubStats } from '../modules/github-stats.js';
import { initLightTrail, destroyLightTrail } from '../modules/light-trail.js';
import { initPageFeatures, destroyPageFeatures } from '../modules/page-features.js';

export function initAllPageModules(container = document) {
  if (window.lucide) {
    window.lucide.createIcons();
  }

  initMagnetic(container);
  initSplitReveal(container);
  initScramble(container);
  initProjectReel(container);
  initMarquee(container);
  initTiltCards(container);
  initImageDistort(container);
  initSkillsPhysics(container);
  initGitHubStats(container);
  initLightTrail(container);
  initPageFeatures(container);
  initHudPage(container);

  if (window.ScrollTrigger) {
    window.ScrollTrigger.refresh();
  }
}

export function destroyAllPageModules() {
  destroyProjectReel();
  destroySplitReveal();
  destroyHudPage();
  destroyMagnetic();
  destroyScramble();
  destroyMarquee();
  destroyTiltCards();
  destroyImageDistort();
  destroySkillsPhysics();
  destroyGitHubStats();
  destroyLightTrail();
  destroyPageFeatures();

  // Ensure no orphan per-page ScrollTriggers remain
  if (window.ScrollTrigger) {
    window.ScrollTrigger.getAll().forEach((st) => st.kill());
  }
}

function updateActiveNav(namespace) {
  document.querySelectorAll('[data-nav-link]').forEach((link) => {
    const target = link.getAttribute('data-nav-link');
    const isActive = target === namespace || (target === 'work' && namespace === 'project');
    link.classList.toggle('text-[var(--acid)]', isActive);
    link.classList.toggle('text-white/80', !isActive);
  });
}

export function initBarba() {
  if (!window.barba) return;

  window.barba.init({
    debug: false,
    prevent: ({ el }) => {
      if (!el) return false;
      const href = el.getAttribute('href') || '';
      return (
        el.hasAttribute('target') ||
        href.endsWith('.pdf') ||
        href.startsWith('mailto:') ||
        href.startsWith('#')
      );
    },
    transitions: [
      {
        name: 'nexus-slice-transition',
        async beforeLeave(data) {
          toggleMenuOverlay(false);
          resetCursorState();
          destroyAllPageModules();
        },
        async leave(data) {
          const nextNs = data.next && data.next.namespace ? data.next.namespace : 'SCENE';
          await playLeaveTransition(nextNs);
        },
        async enter(data) {
          window.scrollTo(0, 0);
          const nextNs = data.next && data.next.namespace ? data.next.namespace : 'home';
          updateActiveNav(nextNs);
          await playEnterTransition(data.next.container);
        },
        async afterEnter(data) {
          initAllPageModules(data.next.container);

          // Focus management & polite announcement per docs/08
          const h1 = data.next.container.querySelector('h1');
          if (h1) {
            h1.setAttribute('tabindex', '-1');
            h1.focus({ preventScroll: true });
          }
          announceA11y(`Navigated to ${document.title}`);
        },
      },
    ],
  });
}

export function navigateToUrl(url) {
  if (window.barba) {
    window.barba.go(url);
  } else {
    window.location.href = url;
  }
}

