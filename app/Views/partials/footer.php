<?php
/**
 * Global Cinematic Footer with Outlined Kinetic Name, Copy-Email, Socials & Lenis Back-to-Top
 * @var array<string, mixed> $site
 */
?>
<footer class="relative z-10 border-t border-white/10 bg-[#05060A]/90 backdrop-blur-xl pt-20 pb-24 px-6 sm:px-10 lg:px-16 overflow-hidden">
  <div class="max-w-[1700px] mx-auto space-y-14">

    <!-- Top Row: Studio Coordinates, Email Copy & Back to Top -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-start justify-between">
      <div class="md:col-span-5 space-y-4">
        <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 font-mono text-xs tracking-[0.16em] text-[var(--acid)]">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span><?= esc($site['availability'] ?? 'Open to select freelance & full-time') ?></span>
        </div>
        <p class="text-lg sm:text-xl text-[var(--text-dim)] max-w-md">
          Engineering dark, high-velocity web products, custom WebGL shaders, and intelligent AI interfaces.
        </p>
        <div class="pt-1">
          <button
            type="button"
            data-copy-email="<?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?>"
            data-magnetic
            data-cursor="copy"
            class="group inline-flex items-center gap-3 font-mono text-sm sm:text-base text-white hover:text-[var(--acid)] transition-colors"
          >
            <i data-lucide="mail" class="w-4 h-4 text-[var(--acid)]"></i>
            <span class="underline underline-offset-8 decoration-white/20 group-hover:decoration-[var(--acid)]">
              <?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?>
            </span>
            <span class="px-2 py-0.5 rounded bg-white/10 text-[10px] tracking-widest uppercase text-[var(--acid)]">CLICK TO COPY</span>
          </button>
        </div>
      </div>

      <!-- Navigation & Social Columns -->
      <div class="md:col-span-4 grid grid-cols-2 gap-8 font-mono text-xs tracking-[0.16em] uppercase">
        <div class="space-y-3">
          <p class="text-[var(--acid)]">// INDEX</p>
          <ul class="space-y-2.5 text-[var(--text-dim)]">
            <li><a href="<?= base_url('/') ?>" class="hover:text-white transition-colors">01 / Home</a></li>
            <li><a href="<?= base_url('work') ?>" class="hover:text-white transition-colors">02 / Work Archive</a></li>
            <li><a href="<?= base_url('about') ?>" class="hover:text-white transition-colors">03 / System About</a></li>
            <li><a href="<?= base_url('contact') ?>" class="hover:text-white transition-colors">04 / Transmission</a></li>
          </ul>
        </div>
        <div class="space-y-3">
          <p class="text-[var(--acid)]">// NETWORKS</p>
          <ul class="space-y-2.5 text-[var(--text-dim)]">
            <?php foreach (($site['socials'] ?? []) as $soc): ?>
              <li>
                <a href="<?= esc($soc['url']) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 hover:text-white transition-colors">
                  <span><?= esc($soc['label']) ?></span>
                  <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-[var(--acid)]"></i>
                </a>
              </li>
            <?php endforeach; ?>
            <li>
              <a href="<?= base_url('cv.pdf') ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-[var(--acid)] hover:underline">
                <span>Resume / CV.pdf</span>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Back to Top Trigger -->
      <div class="md:col-span-3 flex md:justify-end">
        <button
          type="button"
          id="footer-back-to-top"
          data-magnetic
          data-cursor="link"
          class="btn-nexus"
          aria-label="Scroll back to top"
        >
          <span class="btn-fill"></span>
          <span>BACK TO TOP</span>
          <i data-lucide="arrow-up" class="w-4 h-4"></i>
        </button>
      </div>
    </div>

    <!-- Giant Outlined Name that Fills with Lime on Scroll/Hover -->
    <div class="pt-6 border-t border-white/10 select-none overflow-hidden">
      <div
        id="footer-giant-name"
        class="font-display font-black text-[clamp(2.2rem,8.2vw,9.8rem)] leading-[0.88] tracking-tighter text-stroke uppercase text-center"
      >
        MABDEIRA.DEV
      </div>
    </div>

    <!-- Bottom Copyright & Build Telemetry -->
    <div class="flex flex-wrap items-center justify-between gap-4 font-mono text-[11px] tracking-[0.16em] uppercase text-[var(--text-dim)]">
      <span>© <?= date('Y') ?> <?= esc($site['name'] ?? 'Mostepha Amine Bdeira') ?> · LYON, FRANCE · <?= esc($site['email'] ?? 'contact@mabdeira.dev') ?></span>
      <span>STACK // PHP 8.2+ · CODEIGNITER 4 · LARAVEL · SQL · THREE.JS · GSAP 3</span>
    </div>

  </div>
</footer>

