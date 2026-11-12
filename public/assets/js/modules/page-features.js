/**
 * modules/page-features.js — Work Flip Filters, Grid/List Toggle, Case Study Lightbox, About Terminal & Contact AJAX
 */
import { prefersReduced, toggleReducedMotion } from '../core/motion-prefs.js';
import { setTheme, THEME_COLORS, state } from '../core/state.js';
import { showToast } from '../core/utils.js';

let cleanups = [];

export function initPageFeatures(container = document) {
  destroyPageFeatures();

  initWorkArchive(container);
  initCaseStudyLightbox(container);
  initAboutTerminal(container);
  initContactForm(container);
}

/* =====================================================================
   1. WORK ARCHIVE — GSAP Flip Filters & Grid/List View Toggle
   ===================================================================== */
function initWorkArchive(container) {
  const filterBtns = Array.from(container.querySelectorAll('[data-filter-btn]'));
  const gridContainer = container.querySelector('#work-grid-container');
  const listContainer = container.querySelector('#work-list-container');
  const viewBtns = Array.from(container.querySelectorAll('[data-view-mode]'));
  const floatPreview = container.querySelector('#work-list-floating-preview');
  const floatImg = container.querySelector('#work-list-floating-img');

  if (!gridContainer && !listContainer) return;

  const cards = Array.from(container.querySelectorAll('[data-project-card]'));
  const rows = Array.from(container.querySelectorAll('[data-list-row]'));

  // Category Filter with GSAP Flip
  filterBtns.forEach((btn) => {
    const onClick = (e) => {
      e.preventDefault();
      const tag = (btn.getAttribute('data-filter-btn') || 'all').toLowerCase();

      filterBtns.forEach((b) => {
        const active = b === btn;
        b.setAttribute('aria-pressed', active ? 'true' : 'false');
        b.className = active
          ? 'px-4 py-2 rounded-full font-mono text-xs tracking-[0.16em] uppercase border transition-all bg-[var(--acid)] text-[var(--void)] border-[var(--acid)] font-bold shadow-[0_0_20px_var(--acid-glow)]'
          : 'px-4 py-2 rounded-full font-mono text-xs tracking-[0.16em] uppercase border transition-all bg-white/5 text-white/80 border-white/15 hover:border-[var(--acid)]';
      });

      const flipState = !prefersReduced() && window.Flip ? window.Flip.getState(cards) : null;

      cards.forEach((card) => {
        const cardTags = (card.getAttribute('data-tags') || '').toLowerCase().split(',');
        const show = tag === 'all' || cardTags.includes(tag);
        card.style.display = show ? '' : 'none';
      });

      rows.forEach((row) => {
        const rowTags = (row.getAttribute('data-tags') || '').toLowerCase().split(',');
        const show = tag === 'all' || rowTags.includes(tag);
        row.style.display = show ? '' : 'none';
      });

      if (flipState && window.Flip) {
        window.Flip.from(flipState, {
          duration: 0.55,
          ease: 'power3.out',
          scale: true,
          stagger: 0.04,
        });
      }
    };

    btn.addEventListener('click', onClick);
    cleanups.push(() => btn.removeEventListener('click', onClick));
  });

  // Grid <-> List View Toggle
  viewBtns.forEach((btn) => {
    const onClick = () => {
      const mode = btn.getAttribute('data-view-mode') || 'grid';
      viewBtns.forEach((b) => {
        const active = b === btn;
        b.setAttribute('aria-pressed', active ? 'true' : 'false');
        b.className = active
          ? 'px-3.5 py-1.5 rounded-full bg-[var(--acid)] text-[var(--void)] font-bold transition-colors inline-flex items-center gap-1.5'
          : 'px-3.5 py-1.5 rounded-full text-white/75 hover:text-white transition-colors inline-flex items-center gap-1.5';
      });

      if (mode === 'list') {
        gridContainer.classList.add('hidden');
        listContainer.classList.remove('hidden');
      } else {
        listContainer.classList.add('hidden');
        gridContainer.classList.remove('hidden');
        if (floatPreview) floatPreview.style.opacity = '0';
      }
    };

    btn.addEventListener('click', onClick);
    cleanups.push(() => btn.removeEventListener('click', onClick));
  });

  // Floating Preview in List Mode
  if (floatPreview && floatImg) {
    rows.forEach((row) => {
      const onEnter = () => {
        const src = row.getAttribute('data-preview');
        if (src) floatImg.src = src;
        floatPreview.style.opacity = '1';
      };
      const onLeave = () => {
        floatPreview.style.opacity = '0';
      };
      const onMove = (e) => {
        floatPreview.style.transform = `translate3d(${e.clientX + 28}px, ${e.clientY - 90}px, 0)`;
      };

      row.addEventListener('pointerenter', onEnter);
      row.addEventListener('pointerleave', onLeave);
      row.addEventListener('pointermove', onMove);
      cleanups.push(() => {
        row.removeEventListener('pointerenter', onEnter);
        row.removeEventListener('pointerleave', onLeave);
        row.removeEventListener('pointermove', onMove);
      });
    });
  }
}

/* =====================================================================
   2. CASE STUDY LIGHTBOX (Draggable + Esc to Close)
   ===================================================================== */
function initCaseStudyLightbox(container) {
  const modal = container.querySelector('#case-lightbox');
  const closeBtn = container.querySelector('#case-lightbox-close');
  const dragBox = container.querySelector('#case-lightbox-drag');
  const imgEl = container.querySelector('#case-lightbox-img');
  const capEl = container.querySelector('#case-lightbox-caption');
  const triggers = container.querySelectorAll('[data-lightbox-trigger]');

  if (!modal || !imgEl || triggers.length === 0) return;

  const openLightbox = (src, caption) => {
    imgEl.src = src;
    imgEl.alt = caption || 'Case Study Exhibit';
    if (capEl) capEl.textContent = caption || '';
    modal.classList.remove('pointer-events-none');
    modal.style.opacity = '1';
    modal.setAttribute('aria-hidden', 'false');
    if (window.gsap && dragBox) {
      window.gsap.set(dragBox, { x: 0, y: 0 });
    }
  };

  const closeLightbox = () => {
    modal.classList.add('pointer-events-none');
    modal.style.opacity = '0';
    modal.setAttribute('aria-hidden', 'true');
  };

  triggers.forEach((fig) => {
    const onClick = () => {
      openLightbox(fig.getAttribute('data-src'), fig.getAttribute('data-caption'));
    };
    fig.addEventListener('click', onClick);
    cleanups.push(() => fig.removeEventListener('click', onClick));
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', closeLightbox);
    cleanups.push(() => closeBtn.removeEventListener('click', closeLightbox));
  }

  const onKey = (e) => {
    if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
      closeLightbox();
    }
  };
  window.addEventListener('keydown', onKey);
  cleanups.push(() => window.removeEventListener('keydown', onKey));

  if (window.Draggable && dragBox) {
    const d = window.Draggable.create(dragBox, {
      type: 'x,y',
      inertia: true,
      onDragEnd() {
        if (Math.hypot(this.x, this.y) > 160) {
          closeLightbox();
        } else if (window.gsap) {
          window.gsap.to(dragBox, { x: 0, y: 0, duration: 0.35, ease: 'power3.out' });
        }
      },
    });
    cleanups.push(() => d.forEach((inst) => inst.kill()));
  }
}

/* =====================================================================
   3. ABOUT PAGE INTERACTIVE TERMINAL (docs/03 §10.9)
   ===================================================================== */
function initAboutTerminal(container) {
  const form = container.querySelector('#about-terminal-form');
  const input = container.querySelector('#about-terminal-input');
  const output = container.querySelector('#about-terminal-output');
  const quickBtns = container.querySelectorAll('[data-term-quick]');

  if (!form || !input || !output) return;

  function appendLine(html) {
    const div = document.createElement('div');
    div.innerHTML = html;
    output.appendChild(div);
    output.scrollTop = output.scrollHeight;
  }

  function runCommand(raw) {
    const cmd = raw.trim().toLowerCase();
    if (!cmd) return;

    appendLine(`<span class="text-[var(--acid)]">amine@mabdeira.dev:~$</span> <span class="text-white">${raw.replace(/</g, '&lt;')}</span>`);

    if (cmd === 'help') {
      appendLine(
        `<div class="pl-4 text-[var(--cyan)] space-y-1">
          <div>Available commands:</div>
          <div>· <span class="text-white">whoami</span> — Developer &amp; QA profile</div>
          <div>· <span class="text-white">skills</span> — Full-Stack, QA Testing &amp; AI capabilities</div>
          <div>· <span class="text-white">projects</span> — List active portfolio projects</div>
          <div>· <span class="text-white">contact</span> — Display direct contact channels</div>
          <div>· <span class="text-white">theme acid|plasma|cyan</span> — Live-swap studio accent token</div>
          <div>· <span class="text-white">motion</span> — Toggle reduced-motion accessibility mode</div>
          <div>· <span class="text-white">cv</span> — Open curriculum vitae (PDF)</div>
          <div>· <span class="text-white">clear</span> — Clear terminal buffer</div>
        </div>`
      );
    } else if (cmd === 'whoami') {
      appendLine(
        `<div class="pl-4 text-white/90">Mostepha Amine Bdeira // Full-Stack Web Developer &amp; QA Tester based in Lyon, France. 8+ years freelance experience, 30+ web apps delivered, Master Level 7 in Intelligent Computer Systems.</div>`
      );
    } else if (cmd === 'skills' || cmd === 'cat skills.txt') {
      appendLine(
        `<div class="pl-4 text-[var(--acid)]">[BACKEND] PHP 8.3 · CodeIgniter 4 · Laravel · MySQL · PostgreSQL · REST APIs<br>[QA/OPS] PHPUnit · Postman API Testing · Automated Debugging · Linux · Git<br>[FRONTEND/AI] Tailwind CSS · JavaScript · Deep Learning E-Learning · OpenAI/Claude APIs</div>`
      );
    } else if (cmd === 'projects' || cmd === 'ls projects/') {
      appendLine(
        `<div class="pl-4 text-white/90">01/ shopping-france &nbsp; 02/ deep-learning-elearning &nbsp; 03/ m4b-enterprise-suite &nbsp; 04/ api-qa-sentinel &nbsp; 05/ aether-engine &nbsp; 06/ seo-cms-accelerator</div>`
      );
    } else if (cmd === 'contact') {
      appendLine(
        `<div class="pl-4 text-[var(--cyan)]">Email: contact@mabdeira.dev · Phone: +33 6 15 21 88 14 · Location: Lyon, France · Route: <a href="/contact" class="underline text-[var(--acid)]">/contact</a></div>`
      );
    } else if (cmd.startsWith('theme')) {
      const parts = cmd.split(/\s+/);
      const t = parts[1] || 'acid';
      if (['acid', 'plasma', 'cyan'].includes(t)) {
        setTheme(t);
        appendLine(`<div class="pl-4 text-[var(--acid)]">// Theme token updated to: ${t.toUpperCase()}</div>`);
      } else {
        appendLine(`<div class="pl-4 text-[var(--danger)]">Unknown theme. Choose: theme acid | theme plasma | theme cyan</div>`);
      }
    } else if (cmd === 'motion') {
      const enabled = toggleReducedMotion();
      appendLine(`<div class="pl-4 text-white">// Reduced motion: ${enabled ? 'ENABLED' : 'DISABLED'}</div>`);
    } else if (cmd === 'cv') {
      window.open('/cv.pdf', '_blank');
      appendLine(`<div class="pl-4 text-[var(--acid)]">// Opening /cv.pdf in new tab…</div>`);
    } else if (cmd === 'clear') {
      output.innerHTML = '';
    } else {
      appendLine(`<div class="pl-4 text-[var(--danger)]">Command not recognized: "${cmd}". Type <span class="text-white">help</span> for available commands.</div>`);
    }
  }

  const onSubmit = (e) => {
    e.preventDefault();
    const val = input.value;
    input.value = '';
    runCommand(val);
  };

  form.addEventListener('submit', onSubmit);
  cleanups.push(() => form.removeEventListener('submit', onSubmit));

  quickBtns.forEach((btn) => {
    const onClick = () => runCommand(btn.getAttribute('data-term-quick') || 'help');
    btn.addEventListener('click', onClick);
    cleanups.push(() => btn.removeEventListener('click', onClick));
  });
}

/* =====================================================================
   4. CONTACT FORM — Live Character Counter, AJAX Dispatch & Confetti Burst
   ===================================================================== */
function initContactForm(container) {
  const form = container.querySelector('#nexus-contact-form');
  const msgInput = container.querySelector('#contact-message');
  const charCounter = container.querySelector('#contact-char-counter');
  const statusBanner = container.querySelector('#contact-form-status');
  const submitBtn = container.querySelector('#contact-submit-btn');
  const submitLabel = container.querySelector('#contact-submit-label');
  const confettiCanvas = container.querySelector('#contact-confetti-canvas');

  if (!form) return;

  if (msgInput && charCounter) {
    const updateCount = () => {
      const len = msgInput.value.trim().length;
      charCounter.textContent = `${len} / 20 MIN`;
      charCounter.style.color = len >= 20 ? '#D4FF1F' : '#8A90A6';
    };
    msgInput.addEventListener('input', updateCount);
    updateCount();
    cleanups.push(() => msgInput.removeEventListener('input', updateCount));
  }

  const onSubmit = async (e) => {
    e.preventDefault();
    if (!submitBtn || !submitLabel || !statusBanner) return;

    submitBtn.disabled = true;
    submitLabel.textContent = 'ENCRYPTING & SENDING…';
    statusBanner.classList.add('hidden');

    try {
      const formData = new FormData(form);
      const res = await fetch(form.action, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData,
      });

      const json = await res.json();

      // Refresh CSRF token if returned
      if (json.csrfHash) {
        const csrfInput = form.querySelector('input[name^="csrf_"]');
        if (csrfInput) csrfInput.value = json.csrfHash;
      }

      if (res.ok && json.status === 'success') {
        statusBanner.className =
          'mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-400 text-emerald-200 font-mono text-xs uppercase tracking-wider';
        statusBanner.textContent = `${json.message} [${json.transmission || 'TX-OK'}]`;
        statusBanner.classList.remove('hidden');
        submitLabel.textContent = 'TRANSMISSION SENT ✓';
        form.reset();
        triggerConfettiBurst(confettiCanvas);
        showToast('// TRANSMISSION SENT // 200 OK');
      } else {
        const errList = json.errors ? Object.values(json.errors).join(' · ') : json.message || 'Transmission error.';
        statusBanner.className =
          'mb-6 p-4 rounded-xl bg-rose-500/20 border border-rose-400 text-rose-200 font-mono text-xs uppercase tracking-wider';
        statusBanner.textContent = errList;
        statusBanner.classList.remove('hidden');
        submitLabel.textContent = 'SEND TRANSMISSION';

        if (!prefersReduced() && window.gsap) {
          window.gsap.fromTo(form, { x: -8 }, { x: 0, duration: 0.4, ease: 'elastic.out(2, 0.2)' });
        }
      }
    } catch (_) {
      statusBanner.className =
        'mb-6 p-4 rounded-xl bg-rose-500/20 border border-rose-400 text-rose-200 font-mono text-xs uppercase tracking-wider';
      statusBanner.textContent = 'NETWORK SIGNAL INTERRUPTED // Please check connection and retry.';
      statusBanner.classList.remove('hidden');
      submitLabel.textContent = 'SEND TRANSMISSION';
    } finally {
      submitBtn.disabled = false;
    }
  };

  form.addEventListener('submit', onSubmit);
  cleanups.push(() => form.removeEventListener('submit', onSubmit));
}

function triggerConfettiBurst(canvas) {
  if (!canvas || prefersReduced()) return;
  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const rect = canvas.parentElement.getBoundingClientRect();
  canvas.width = rect.width;
  canvas.height = rect.height;

  const hex = (THEME_COLORS[state.theme] || THEME_COLORS.acid).hex;
  const colors = [hex, '#2DE2E6', '#7B5CFF', '#EDEFF5'];
  const pieces = Array.from({ length: 48 }, () => ({
    x: canvas.width / 2,
    y: canvas.height * 0.75,
    vx: (Math.random() - 0.5) * 12,
    vy: -6 - Math.random() * 10,
    size: 4 + Math.random() * 5,
    color: colors[Math.floor(Math.random() * colors.length)],
    alpha: 1,
  }));

  function step() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    let alive = false;
    pieces.forEach((p) => {
      p.x += p.vx;
      p.y += p.vy;
      p.vy += 0.28;
      p.alpha -= 0.016;
      if (p.alpha > 0) {
        alive = true;
        ctx.globalAlpha = Math.max(0, p.alpha);
        ctx.fillStyle = p.color;
        ctx.fillRect(p.x, p.y, p.size, p.size);
      }
    });
    ctx.globalAlpha = 1;
    if (alive) requestAnimationFrame(step);
    else ctx.clearRect(0, 0, canvas.width, canvas.height);
  }
  requestAnimationFrame(step);
}

export function destroyPageFeatures() {
  cleanups.forEach((fn) => fn());
  cleanups = [];
}

