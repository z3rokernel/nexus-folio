<?php
/**
 * Full-Screen Menu Overlay with Staggered Reveal, Cursor Preview & Motion/Theme Controls
 * @var array<string, mixed> $site
 * @var string $namespace
 * @var array<int, array<string, mixed>> $paletteProjects
 */
$navItems = [
    ['index' => '01', 'label' => 'CONTROL ROOM', 'sub' => 'Home & Shader Stage',      'href' => base_url('/'),        'img' => '/assets/img/projects/aether-engine/cover.svg'],
    ['index' => '02', 'label' => 'WORK ARCHIVE', 'sub' => 'Selected Scenes & Lab',    'href' => base_url('work'),     'img' => '/assets/img/projects/kronos-neural-hud/cover.svg'],
    ['index' => '03', 'label' => 'SYSTEM ABOUT', 'sub' => 'Terminal, Bio & Timeline', 'href' => base_url('about'),    'img' => '/assets/img/projects/synapse-rag-os/cover.svg'],
    ['index' => '04', 'label' => 'TRANSMISSION', 'sub' => 'Initiate Project Contact', 'href' => base_url('contact'),  'img' => '/assets/img/projects/hyperion-synth/cover.svg'],
];
?>
<div
  id="nexus-menu-overlay"
  class="fixed inset-0 z-[95] bg-[#05060A]/96 backdrop-blur-2xl pointer-events-none opacity-0 transition-opacity duration-500 flex flex-col justify-between p-6 sm:p-12 lg:p-16 overflow-y-auto"
  style="clip-path: circle(0% at 94% 4%);"
  aria-hidden="true"
  role="dialog"
  aria-modal="true"
  aria-label="Site Navigation Menu"
>
  <div class="bg-studio-grid absolute inset-0 pointer-events-none opacity-60"></div>

  <!-- Top Spacer for HUD Header -->
  <div class="relative z-10 flex items-center justify-between pt-12 sm:pt-6">
    <span class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">// NAVIGATION MATRIX [ESC TO CLOSE]</span>
  </div>

  <!-- Main Grid: Giant Staggered Links + Floating Preview Card -->
  <div class="relative z-10 my-auto py-8 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center max-w-[1600px] w-full mx-auto">
    <nav aria-label="Full Screen Navigation" class="lg:col-span-8 space-y-3 sm:space-y-5">
      <?php foreach ($navItems as $item): ?>
        <div class="overflow-hidden border-b border-white/10 pb-3 sm:pb-4">
          <a
            href="<?= esc($item['href']) ?>"
            data-menu-link
            data-preview="<?= esc($item['img']) ?>"
            data-sub="<?= esc($item['sub']) ?>"
            class="group flex items-baseline justify-between gap-4 py-1 text-left"
          >
            <div class="flex items-baseline gap-4 sm:gap-6">
              <span class="font-mono text-xs sm:text-sm text-[var(--acid)] tracking-[0.2em]"><?= esc($item['index']) ?> //</span>
              <span class="font-display text-3xl sm:text-5xl xl:text-6xl font-extrabold tracking-tight text-white group-hover:text-[var(--acid)] transition-colors" data-scramble="<?= esc($item['label']) ?>">
                <?= esc($item['label']) ?>
              </span>
            </div>
            <span class="hidden sm:inline-flex items-center gap-2 font-mono text-xs tracking-[0.16em] uppercase text-[var(--text-dim)] group-hover:text-white transition-colors">
              <span><?= esc($item['sub']) ?></span>
              <i data-lucide="arrow-up-right" class="w-4 h-4 text-[var(--acid)] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
            </span>
          </a>
        </div>
      <?php endforeach; ?>
    </nav>

    <!-- Right Column: Hover Preview & Studio Preferences -->
    <div class="lg:col-span-4 space-y-6">
      <div class="glass-card p-4 border border-white/15">
        <div class="aspect-video rounded-xl overflow-hidden bg-[#0B0D14] mb-3 relative">
          <img
            id="menu-preview-img"
            src="<?= base_url('assets/img/projects/aether-engine/cover.svg') ?>"
            alt="Navigation Scene Preview"
            width="640"
            height="360"
            class="w-full h-full object-cover transition-transform duration-700"
          >
          <div class="absolute bottom-2.5 left-3 px-2.5 py-1 rounded bg-black/75 font-mono text-[10px] tracking-[0.18em] text-[var(--acid)] uppercase" id="menu-preview-caption">
            SCENE PREVIEW // CONTROL ROOM
          </div>
        </div>

        <!-- Accessibility & Studio Toggles (Required by docs/08) -->
        <div class="space-y-3 pt-2 border-t border-white/10">
          <div class="flex items-center justify-between">
            <span class="font-mono text-xs uppercase tracking-[0.14em] text-[var(--text-dim)]">Accent Theme</span>
            <div class="flex items-center gap-1.5" role="group" aria-label="Theme Switcher">
              <button type="button" data-set-theme="acid" class="px-2.5 py-1 rounded font-mono text-[10px] uppercase tracking-wider bg-[#D4FF1F]/20 text-[#D4FF1F] border border-[#D4FF1F]/50">Acid</button>
              <button type="button" data-set-theme="plasma" class="px-2.5 py-1 rounded font-mono text-[10px] uppercase tracking-wider bg-[#7B5CFF]/20 text-[#7B5CFF] border border-[#7B5CFF]/50">Plasma</button>
              <button type="button" data-set-theme="cyan" class="px-2.5 py-1 rounded font-mono text-[10px] uppercase tracking-wider bg-[#2DE2E6]/20 text-[#2DE2E6] border border-[#2DE2E6]/50">Cyan</button>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <span class="font-mono text-xs uppercase tracking-[0.14em] text-[var(--text-dim)]">Reduce Motion</span>
            <button
              type="button"
              id="menu-reduced-motion-toggle"
              aria-pressed="false"
              class="px-3 py-1 rounded-full font-mono text-[11px] uppercase tracking-wider border border-white/15 bg-white/5 text-white hover:border-[var(--acid)] transition-colors"
            >
              <span id="menu-reduced-motion-state">OFF (FULL MOTION)</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Meta Bar -->
  <div class="relative z-10 flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-white/10 font-mono text-xs tracking-[0.14em] text-[var(--text-dim)]">
    <div class="flex items-center gap-2">
      <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
      <span><?= esc($site['availability'] ?? 'Available for select projects') ?></span>
    </div>
    <div class="flex items-center gap-6">
      <button type="button" data-copy-email="<?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?>" class="hover:text-[var(--acid)] transition-colors">
        <?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?> [COPY]
      </button>
      <a href="<?= base_url('cv.pdf') ?>" target="_blank" rel="noopener" class="text-[var(--acid)] hover:underline">DOWNLOAD CV.PDF</a>
    </div>
  </div>
</div>
