/**
 * modules/split-reveal.js — Accessible SplitText Reveals, Rotating Role, Scrub Manifesto & Counters
 */
import { prefersReduced, EASE, DUR, STAGGER } from '../core/motion-prefs.js';

let triggers = [];
let roleTimer = null;

export function initSplitReveal(container = document) {
  destroySplitReveal();
  if (!window.gsap) return;

  const gsap = window.gsap;

  // 1. Rotating Role Badge on Hero
  const roleEl = container.querySelector('#hero-rotating-role');
  if (roleEl) {
    let roles = ['Full-Stack Developer', 'Creative Technologist', 'AI Systems Builder'];
    try {
      roles = JSON.parse(roleEl.getAttribute('data-roles') || '[]') || roles;
    } catch (_) {}

    let rIdx = 0;
    roleTimer = setInterval(() => {
      if (document.hidden || prefersReduced()) return;
      rIdx = (rIdx + 1) % roles.length;
      const nextText = roles[rIdx];
      if (window.ScrambleTextPlugin) {
        gsap.to(roleEl, {
          duration: 0.9,
          scrambleText: { text: nextText, chars: '01/#X$<>_', speed: 0.5 },
        });
      } else {
        roleEl.textContent = nextText;
      }
    }, 3400);
  }

  // 2. Number Counters ([data-counter])
  const counters = container.querySelectorAll('[data-counter]');
  counters.forEach((el) => {
    const target = parseInt(el.getAttribute('data-counter') || '0', 10);
    if (prefersReduced() || !window.ScrollTrigger) {
      el.textContent = target.toLocaleString();
      return;
    }
    const proxy = { val: 0 };
    const st = window.ScrollTrigger.create({
      trigger: el,
      start: 'top 88%',
      once: true,
      onEnter: () => {
        gsap.to(proxy, {
          val: target,
          duration: 1.6,
          ease: EASE.out,
          onUpdate: () => {
            el.textContent = Math.round(proxy.val).toLocaleString();
          },
        });
      },
    });
    triggers.push(st);
  });

  if (prefersReduced()) return;

  // 3. Hero Headline Split Rise
  const heroLines = container.querySelectorAll('[data-hero-split]');
  if (heroLines.length > 0) {
    gsap.fromTo(
      heroLines,
      { yPercent: 45, opacity: 0, rotateX: -20 },
      {
        yPercent: 0,
        opacity: 1,
        rotateX: 0,
        duration: DUR.lg,
        stagger: 0.1,
        ease: EASE.out,
      }
    );
  }

  // 4. Intro Word-by-Word Scrub Reveal (#scrub-manifesto)
  const manifesto = container.querySelector('#scrub-manifesto');
  if (manifesto && window.ScrollTrigger) {
    const st = gsap.fromTo(
      manifesto,
      { opacity: 0.2, y: 24 },
      {
        opacity: 1,
        y: 0,
        ease: 'none',
        scrollTrigger: {
          trigger: manifesto,
          start: 'top 85%',
          end: 'bottom 45%',
          scrub: true,
        },
      }
    );
    if (st.scrollTrigger) triggers.push(st.scrollTrigger);
  }

  // 5. Generic [data-split] & [data-reveal] elements
  const revealEls = container.querySelectorAll('[data-split], [data-reveal]');
  revealEls.forEach((el) => {
    if (!window.ScrollTrigger) return;
    const tween = gsap.fromTo(
      el,
      { y: 36, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        duration: DUR.md,
        ease: EASE.out,
        scrollTrigger: {
          trigger: el,
          start: 'top 88%',
          once: true,
        },
      }
    );
    if (tween.scrollTrigger) triggers.push(tween.scrollTrigger);
  });

  // 6. Footer Giant Name Lime Fill on Scroll
  const footerName = container.querySelector('#footer-giant-name');
  if (footerName && window.ScrollTrigger) {
    const st = window.ScrollTrigger.create({
      trigger: footerName,
      start: 'top 85%',
      onEnter: () => footerName.classList.add('is-active'),
      onLeaveBack: () => footerName.classList.remove('is-active'),
    });
    triggers.push(st);
  }
}

export function destroySplitReveal() {
  if (roleTimer) {
    clearInterval(roleTimer);
    roleTimer = null;
  }
  triggers.forEach((st) => st.kill());
  triggers = [];
}

