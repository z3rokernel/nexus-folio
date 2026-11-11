<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Contact Page (/contact) — AJAX Dispatch, Honeypot, CSRF, Throttle & Particle Burst
 * @var array<string, mixed> $site
 */
$flashSuccess = session()->getFlashdata('success');
$flashError   = session()->getFlashdata('error');
$flashErrors  = session()->getFlashdata('errors') ?? [];
?>

<section data-scene="01" data-scene-label="CONTACT TRANSMISSION" class="relative pt-32 pb-28 px-6 sm:px-10 lg:px-16 overflow-hidden">
  <!-- Interactive Cursor Trail Background Canvas -->
  <canvas id="contact-trail-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0" aria-hidden="true"></canvas>

  <div class="relative z-10 max-w-[1650px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-14 items-start">

    <!-- Left Column: Direct Coordinates & Availability Status -->
    <div class="lg:col-span-5 space-y-10">
      <div class="space-y-5">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/40 font-mono text-xs tracking-[0.18em] uppercase text-emerald-300">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
          <span><?= esc($site['availability'] ?? 'Available for freelance & full-time') ?></span>
        </div>

        <h1
          data-split="chars"
          aria-label="INITIATE TRANSMISSION"
          class="font-display section-display-size font-black uppercase tracking-tight text-white"
        >
          INITIATE <span class="text-chrome">TRANSMISSION.</span>
        </h1>

        <p class="text-base sm:text-lg text-[var(--text-dim)] leading-relaxed">
          Have a visionary product, creative WebGL launch, or AI platform to architect? Send a direct dispatch below or copy my coordinates.
        </p>
      </div>

      <!-- Direct Channels Card -->
      <div class="glass-card p-7 sm:p-8 border border-white/15 space-y-6 font-mono">
        <div class="space-y-2 border-b border-white/10 pb-5">
          <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">DIRECT FREQUENCY // EMAIL</span>
          <div class="flex items-center justify-between gap-3">
            <span class="text-sm sm:text-base text-white font-semibold break-all"><?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?></span>
            <button
              type="button"
              data-copy-email="<?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?>"
              class="px-3 py-1.5 rounded-lg bg-[var(--acid)] text-[var(--void)] text-[11px] font-bold uppercase tracking-wider shrink-0 hover:brightness-110 transition"
            >
              COPY
            </button>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 border-b border-white/10 pb-5">
          <div>
            <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">BASE SECTOR</span>
            <p class="text-xs sm:text-sm text-white mt-1"><?= esc($site['city'] ?? 'Paris, France') ?></p>
          </div>
          <div>
            <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">RESPONSE SLA</span>
            <p class="text-xs sm:text-sm text-[var(--acid)] mt-1">&lt; 24 HOURS</p>
          </div>
        </div>

        <div class="space-y-2">
          <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">VERIFIED PROFILES</span>
          <div class="flex flex-wrap gap-3 pt-1">
            <?php foreach (($site['socials'] ?? []) as $soc): ?>
              <a
                href="<?= esc($soc['url']) ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="px-3.5 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-[var(--acid)] text-xs text-white transition-colors inline-flex items-center gap-2"
              >
                <span><?= esc($soc['label']) ?></span>
                <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-[var(--acid)]"></i>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Secure Encrypted Contact Form -->
    <div class="lg:col-span-7">
      <div class="glass-card p-8 sm:p-12 border border-white/15 relative overflow-hidden">

        <!-- Particle Burst Canvas for Form Success -->
        <canvas id="contact-confetti-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-20" aria-hidden="true"></canvas>

        <!-- Server-Side Flash Fallbacks (when JS is disabled) -->
        <?php if ($flashSuccess): ?>
          <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-400 text-emerald-200 font-mono text-xs uppercase tracking-wider" role="alert">
            <?= esc((string) $flashSuccess) ?>
          </div>
        <?php endif; ?>
        <?php if ($flashError): ?>
          <div class="mb-6 p-4 rounded-xl bg-rose-500/20 border border-rose-400 text-rose-200 font-mono text-xs uppercase tracking-wider" role="alert">
            <?= esc((string) $flashError) ?>
          </div>
        <?php endif; ?>

        <!-- AJAX Status Banner -->
        <div
          id="contact-form-status"
          class="hidden mb-6 p-4 rounded-xl font-mono text-xs uppercase tracking-wider"
          role="alert"
          aria-live="assertive"
        ></div>

        <form
          id="nexus-contact-form"
          action="<?= base_url('contact') ?>"
          method="post"
          novalidate
          class="space-y-8 relative z-10"
        >
          <?= csrf_field() ?>

          <!-- Honeypot Trap (Hidden from humans & screen readers) -->
          <div class="hidden" aria-hidden="true">
            <label for="website_url">Leave this field empty</label>
            <input type="text" name="honeypot" id="website_url" tabindex="-1" autocomplete="off" value="">
          </div>

          <!-- Sender Name -->
          <div class="space-y-2">
            <label for="contact-name" class="block font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">
              01 // OPERATOR NAME *
            </label>
            <input
              type="text"
              id="contact-name"
              name="name"
              required
              minlength="2"
              maxlength="140"
              value="<?= esc((string) old('name')) ?>"
              placeholder="e.g. Alex Vance // Creative Director"
              class="w-full px-5 py-4 rounded-xl bg-[#05060A]/90 border border-white/15 focus:border-[var(--acid)] text-white placeholder-[var(--text-dim)]/60 font-sans text-base transition-colors"
            >
            <?php if (! empty($flashErrors['name'])): ?>
              <p class="font-mono text-xs text-[var(--danger)]"><?= esc($flashErrors['name']) ?></p>
            <?php endif; ?>
          </div>

          <!-- Sender Email -->
          <div class="space-y-2">
            <label for="contact-email" class="block font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">
              02 // RETURN FREQUENCY (EMAIL) *
            </label>
            <input
              type="email"
              id="contact-email"
              name="email"
              required
              maxlength="180"
              value="<?= esc((string) old('email')) ?>"
              placeholder="alex@studio.ai"
              class="w-full px-5 py-4 rounded-xl bg-[#05060A]/90 border border-white/15 focus:border-[var(--acid)] text-white placeholder-[var(--text-dim)]/60 font-sans text-base transition-colors"
            >
            <?php if (! empty($flashErrors['email'])): ?>
              <p class="font-mono text-xs text-[var(--danger)]"><?= esc($flashErrors['email']) ?></p>
            <?php endif; ?>
          </div>

          <!-- Transmission Payload (Message) -->
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label for="contact-message" class="block font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">
                03 // TRANSMISSION PAYLOAD (MIN 20 CHARS) *
              </label>
              <span id="contact-char-counter" class="font-mono text-[11px] text-[var(--text-dim)] tabular-nums">0 / 20 MIN</span>
            </div>
            <textarea
              id="contact-message"
              name="message"
              rows="5"
              required
              minlength="20"
              maxlength="5000"
              placeholder="Tell me about your timeline, scope, architectural goals, or creative direction…"
              class="w-full px-5 py-4 rounded-xl bg-[#05060A]/90 border border-white/15 focus:border-[var(--acid)] text-white placeholder-[var(--text-dim)]/60 font-sans text-base transition-colors resize-y"
            ><?= esc((string) old('message')) ?></textarea>
            <?php if (! empty($flashErrors['message'])): ?>
              <p class="font-mono text-xs text-[var(--danger)]"><?= esc($flashErrors['message']) ?></p>
            <?php endif; ?>
          </div>

          <!-- Submit Button with Progress Ring Morph -->
          <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
            <p class="font-mono text-[11px] tracking-[0.14em] text-[var(--text-dim)] uppercase">
              PROTECTED BY CSRF · HONEYPOT · 5/MIN THROTTLE
            </p>

            <button
              type="submit"
              id="contact-submit-btn"
              data-magnetic
              data-cursor="link"
              class="btn-nexus btn-nexus-primary min-w-[240px]"
            >
              <span class="btn-fill"></span>
              <span id="contact-submit-label">SEND TRANSMISSION</span>
              <i data-lucide="send" id="contact-submit-icon" class="w-4 h-4"></i>
            </button>
          </div>
        </form>

      </div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>
