<?php
/**
 * Global HUD Frame & Top Studio Bar
 * @var array<string, mixed> $site
 * @var string $namespace
 */
$current = $namespace ?? 'home';
?>
<!-- 1px Viewport Corner Brackets -->
<div class="hud-bracket hud-bracket-tl" aria-hidden="true"></div>
<div class="hud-bracket hud-bracket-tr" aria-hidden="true"></div>
<div class="hud-bracket hud-bracket-bl" aria-hidden="true"></div>
<div class="hud-bracket hud-bracket-br" aria-hidden="true"></div>

<!-- Top Navigation / Telemetry Header -->
<header class="fixed top-0 inset-x-0 z-50 px-5 sm:px-8 py-4 pointer-events-none">
  <div class="max-w-[1800px] mx-auto flex items-center justify-between gap-4">

    <!-- Top-Left: Personal Brand Mark -->
    <a
      href="<?= base_url('/') ?>"
      data-magnetic
      data-cursor="link"
      class="pointer-events-auto group inline-flex items-center gap-3 px-3.5 py-2 rounded-full bg-[#0B0D14]/80 backdrop-blur-md border border-white/10 hover:border-[var(--acid)]/60 transition-colors"
      aria-label="Mostepha Amine Bdeira — mabdeira.dev Home"
    >
      <span class="w-2.5 h-2.5 rounded-full bg-[var(--acid)] shadow-[0_0_12px_var(--acid)] group-hover:scale-125 transition-transform"></span>
      <span class="font-display font-bold text-xs tracking-[0.14em] text-white">M.A.BDEIRA<span class="text-[var(--acid)]">//</span></span>
      <span class="hidden sm:inline-block font-mono text-[11px] tracking-[0.12em] text-[var(--text-dim)] border-l border-white/10 pl-2.5">MABDEIRA.DEV</span>
    </a>

    <!-- Top-Center: Live Clock + City + Quick Primary Links -->
    <div class="hidden lg:flex items-center gap-6 px-5 py-2 rounded-full bg-[#0B0D14]/75 backdrop-blur-md border border-white/10 pointer-events-auto">
      <div class="flex items-center gap-2 font-mono text-[11px] tracking-[0.14em] text-[var(--text-dim)]">
        <span id="hud-daynight-dot" class="w-2 h-2 rounded-full bg-[var(--cyan)]" title="Local Telemetry Active"></span>
        <span class="text-white uppercase"><?= esc($site['city'] ?? 'Lyon, France') ?></span>
        <span class="text-white/30">//</span>
        <time id="hud-clock" class="text-[var(--acid)] tabular-nums">19:00:00 CET</time>
      </div>

      <span class="h-3.5 w-px bg-white/10" aria-hidden="true"></span>

      <nav aria-label="Primary Navigation" class="flex items-center gap-5 font-mono text-[11px] tracking-[0.16em] uppercase">
        <a href="<?= base_url('/') ?>" data-scramble="HOME" data-nav-link="home" class="hover:text-[var(--acid)] transition-colors <?= $current === 'home' ? 'text-[var(--acid)]' : 'text-white/80' ?>">HOME</a>
        <a href="<?= base_url('work') ?>" data-scramble="WORK" data-nav-link="work" class="hover:text-[var(--acid)] transition-colors <?= in_array($current, ['work', 'project'], true) ? 'text-[var(--acid)]' : 'text-white/80' ?>">WORK</a>
        <a href="<?= base_url('about') ?>" data-scramble="ABOUT" data-nav-link="about" class="hover:text-[var(--acid)] transition-colors <?= $current === 'about' ? 'text-[var(--acid)]' : 'text-white/80' ?>">ABOUT</a>
        <a href="<?= base_url('contact') ?>" data-scramble="CONTACT" data-nav-link="contact" class="hover:text-[var(--acid)] transition-colors <?= $current === 'contact' ? 'text-[var(--acid)]' : 'text-white/80' ?>">CONTACT</a>
      </nav>
    </div>

    <!-- Top-Right: Command Palette Trigger + Theme + Sound + Menu Button -->
    <div class="flex items-center gap-2.5 pointer-events-auto">
      <!-- Command Palette Button -->
      <button
        type="button"
        id="cmd-palette-trigger"
        data-magnetic
        data-cursor="link"
        class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-[#0B0D14]/80 backdrop-blur-md border border-white/10 hover:border-[var(--acid)]/60 font-mono text-[11px] tracking-[0.12em] text-[var(--text-dim)] hover:text-white transition-colors"
        aria-label="Open Command Palette (Ctrl+K)"
      >
        <i data-lucide="terminal" class="w-3.5 h-3.5 text-[var(--acid)]"></i>
        <span>CMD</span>
        <kbd class="px-1.5 py-0.5 text-[10px] rounded bg-white/10 text-white font-mono">⌘K</kbd>
      </button>

      <!-- Live Theme Cycle Button -->
      <button
        type="button"
        id="hud-theme-btn"
        data-magnetic
        data-cursor="link"
        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-full bg-[#0B0D14]/80 backdrop-blur-md border border-white/10 hover:border-[var(--acid)]/60 font-mono text-[11px] tracking-[0.12em] text-white/80 hover:text-[var(--acid)] transition-colors"
        aria-label="Switch Color Theme (Acid, Plasma, Cyan)"
        title="Switch Theme Accent"
      >
        <span class="w-2.5 h-2.5 rounded-full bg-[var(--acid)]"></span>
        <span id="hud-theme-label" class="hidden md:inline uppercase">ACID</span>
      </button>

      <!-- Background Music Toggle Button (Independent from SFX) -->
      <button
        type="button"
        id="hud-bgm-btn"
        data-magnetic
        data-cursor="link"
        aria-pressed="false"
        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-full bg-[#0B0D14]/80 backdrop-blur-md border border-white/10 hover:border-[var(--acid)]/60 font-mono text-[11px] tracking-[0.12em] text-[var(--text-dim)] hover:text-white transition-colors"
        aria-label="Toggle Ambient Background Music"
        title="Toggle Background Synth Music"
      >
        <i data-lucide="music" class="w-3.5 h-3.5"></i>
        <span id="hud-bgm-dot" class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
        <span id="hud-bgm-label" class="hidden xl:inline">BGM:OFF</span>
      </button>

      <!-- Sound Effects Toggle Button (Default OFF) -->
      <button
        type="button"
        id="hud-sound-btn"
        data-magnetic
        data-cursor="link"
        aria-pressed="false"
        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-full bg-[#0B0D14]/80 backdrop-blur-md border border-white/10 hover:border-[var(--acid)]/60 font-mono text-[11px] tracking-[0.12em] text-[var(--text-dim)] hover:text-white transition-colors"
        aria-label="Toggle UI Sound Effects"
        title="Toggle UI Sound Effects"
      >
        <i data-lucide="volume-x" id="hud-sound-icon" class="w-3.5 h-3.5"></i>
        <span id="hud-sound-label" class="hidden xl:inline">SFX:OFF</span>
      </button>

      <!-- Menu Overlay Trigger -->
      <button
        type="button"
        id="menu-toggle-btn"
        data-magnetic
        data-cursor="link"
        aria-expanded="false"
        aria-controls="nexus-menu-overlay"
        class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-[var(--graphite)]/90 backdrop-blur-md border border-white/15 hover:border-[var(--acid)] font-mono text-xs tracking-[0.16em] uppercase text-white transition-colors"
      >
        <span id="menu-toggle-label">MENU</span>
        <span class="flex flex-col gap-1 w-4">
          <span id="menu-bar-1" class="block h-[1.5px] w-full bg-[var(--acid)] transition-transform duration-300"></span>
          <span id="menu-bar-2" class="block h-[1.5px] w-3/4 bg-white ml-auto transition-transform duration-300"></span>
        </span>
      </button>
    </div>
  </div>
</header>

<!-- Bottom HUD Telemetry Bar -->
<div class="fixed bottom-0 inset-x-0 z-40 px-5 sm:px-8 py-3.5 pointer-events-none">
  <div class="max-w-[1800px] mx-auto flex items-center justify-between font-mono text-[11px] tracking-[0.16em] uppercase text-[var(--text-dim)]">

    <!-- Bottom-Left: Scroll % & Progress Track + Cursor Coordinates -->
    <div class="flex items-center gap-4 bg-[#0B0D14]/70 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/10">
      <div class="flex items-center gap-2">
        <span class="text-white/50">SCRL</span>
        <span id="hud-scroll-pct" class="text-[var(--acid)] tabular-nums w-9">000%</span>
      </div>
      <div class="w-16 sm:w-24 h-1 bg-white/10 rounded-full overflow-hidden">
        <div id="hud-scroll-bar" class="h-full bg-[var(--acid)] w-0"></div>
      </div>
      <span id="hud-coords" class="hidden md:inline-block text-[10px] text-white/60 tabular-nums border-l border-white/10 pl-3">
        X:0000 Y:0000
      </span>
    </div>

    <!-- Bottom-Center: Scroll Prompt -->
    <div id="hud-scroll-hint" class="hidden sm:flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#0B0D14]/70 backdrop-blur-md border border-white/10 text-[10px] tracking-[0.22em] text-white/70 transition-opacity duration-500">
      <span class="w-1.5 h-1.5 rounded-full bg-[var(--acid)] animate-ping"></span>
      <span>SCROLL TO SCRUB TIMELINE</span>
    </div>

    <!-- Bottom-Right: Active Scene Index -->
    <div class="flex items-center gap-2.5 bg-[#0B0D14]/70 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/10">
      <span class="text-white/50">SCENE</span>
      <span id="hud-scene-index" class="text-white font-semibold tabular-nums">01 / 09</span>
    </div>

  </div>
</div>

