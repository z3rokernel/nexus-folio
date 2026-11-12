<?php
/**
 * Command Palette Modal (Ctrl/⌘ + K)
 * @var array<string, mixed> $site
 * @var array<int, array<string, mixed>> $paletteProjects
 */
?>
<div
  id="command-palette-backdrop"
  class="fixed inset-0 z-[125] bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-200 flex items-start justify-center pt-[12vh] px-4"
  aria-hidden="true"
  role="dialog"
  aria-modal="true"
  aria-label="Command Palette"
>
  <div
    id="command-palette-dialog"
    class="w-full max-w-2xl glass-card border border-[var(--acid)]/40 shadow-[0_25px_90px_rgba(0,0,0,0.95)] overflow-hidden transform scale-95 transition-transform duration-200"
  >
    <!-- Search Input Header -->
    <div class="flex items-center gap-3 px-5 py-4 border-b border-white/10 bg-[#0B0D14]/90">
      <i data-lucide="terminal" class="w-5 h-5 text-[var(--acid)] shrink-0"></i>
      <input
        type="text"
        id="command-palette-input"
        placeholder="Type a command or search scenes (e.g. 'Shopping France', 'Music', 'Experience', 'Theme')…"
        autocomplete="off"
        class="w-full bg-transparent text-white placeholder-[var(--text-dim)] font-mono text-sm focus:outline-none"
        aria-label="Search commands and projects"
      >
      <kbd class="px-2 py-1 rounded bg-white/10 font-mono text-[10px] text-[var(--text-dim)] shrink-0">ESC</kbd>
    </div>

    <!-- Command Results List -->
    <ul
      id="command-palette-list"
      role="listbox"
      class="max-h-[55vh] overflow-y-auto divide-y divide-white/5 p-2 space-y-1"
    >
      <!-- Navigation Commands -->
      <li data-cmd-item data-type="nav" data-href="<?= base_url('/') ?>" data-keywords="home hero studio start index" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="compass" class="w-4 h-4 text-[var(--acid)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Go to Home // Control Room</p>
            <p class="text-xs text-[var(--text-dim)]">Liquid Shader Stage &amp; Featured Timeline</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--acid)]">SCENE 01</span>
      </li>

      <li data-cmd-item data-type="nav" data-href="<?= base_url('work') ?>" data-keywords="work projects archive portfolio case studies" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="film" class="w-4 h-4 text-[var(--acid)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Go to Work Archive</p>
            <p class="text-xs text-[var(--text-dim)]">All Interactive Case Studies &amp; Flip Filters</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--acid)]">/WORK</span>
      </li>

      <li data-cmd-item data-type="nav" data-href="<?= base_url('about') ?>" data-keywords="about bio terminal skills experience resume" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="cpu" class="w-4 h-4 text-[var(--acid)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Go to System About &amp; Terminal</p>
            <p class="text-xs text-[var(--text-dim)]">Interactive CLI, Experience Timeline &amp; Portrait</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--acid)]">/ABOUT</span>
      </li>

      <li data-cmd-item data-type="nav" data-href="<?= base_url('contact') ?>" data-keywords="contact hire email message form transmission" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="send" class="w-4 h-4 text-[var(--acid)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Initiate Transmission // Contact</p>
            <p class="text-xs text-[var(--text-dim)]">Direct Encrypted Dispatch &amp; Availability</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--acid)]">/CONTACT</span>
      </li>

      <!-- Project Scenes -->
      <?php foreach (($paletteProjects ?? []) as $proj): ?>
        <li
          data-cmd-item
          data-type="nav"
          data-href="<?= base_url('work/' . $proj['slug']) ?>"
          data-keywords="project <?= esc(strtolower($proj['title'] . ' ' . $proj['subtitle'] . ' ' . implode(' ', $proj['tags'] ?? []))) ?>"
          role="option"
          tabindex="-1"
          class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors"
        >
          <div class="flex items-center gap-3">
            <i data-lucide="sparkles" class="w-4 h-4 text-[var(--cyan)]"></i>
            <div>
              <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Project // <?= esc($proj['title']) ?></p>
              <p class="text-xs text-[var(--text-dim)]"><?= esc($proj['subtitle']) ?></p>
            </div>
          </div>
          <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--cyan)]"><?= esc((string) $proj['year']) ?></span>
        </li>
      <?php endforeach; ?>

      <!-- System Actions -->
      <li data-cmd-item data-type="action" data-action="copy-email" data-email="<?= esc($site['email'] ?? 'contact@mabdeira.dev') ?>" data-keywords="copy email address mail clipboard" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="copy" class="w-4 h-4 text-[var(--plasma)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Action // Copy Email Address</p>
            <p class="text-xs text-[var(--text-dim)]">Copy <?= esc($site['email'] ?? 'contact@mabdeira.dev') ?> to clipboard</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-white/60">ACTION</span>
      </li>

      <li data-cmd-item data-type="nav" data-href="<?= base_url('about#experience-timeline') ?>" data-keywords="experience education study master degree career timeline" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="graduation-cap" class="w-4 h-4 text-[var(--plasma)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">View Experience &amp; Academic Studies</p>
            <p class="text-xs text-[var(--text-dim)]">8+ yrs Full-Stack Freelance &amp; Master Level 7 (Intelligent Computer Systems)</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-white/60">TIMELINE</span>
      </li>

      <li data-cmd-item data-type="action" data-action="toggle-bgm" data-keywords="music background ambient synthwave soundtrack play pause bgm" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="music" class="w-4 h-4 text-[var(--acid)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Action // Toggle Background Music (BGM)</p>
            <p class="text-xs text-[var(--text-dim)]">Play or pause atmospheric sci-fi ambient synth soundtrack</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--acid)]">MUSIC</span>
      </li>

      <li data-cmd-item data-type="action" data-action="cycle-theme" data-keywords="switch theme color acid lime plasma violet cyan" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="palette" class="w-4 h-4 text-[var(--acid)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Action // Switch Accent Theme</p>
            <p class="text-xs text-[var(--text-dim)]">Cycle between Acid Lime, Plasma Violet, and Cyber Cyan</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--acid)]">THEME</span>
      </li>

      <li data-cmd-item data-type="action" data-action="toggle-sound" data-keywords="toggle sound audio sfx mute unmute synth" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="volume-2" class="w-4 h-4 text-[var(--cyan)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Action // Toggle Studio Sound Effects</p>
            <p class="text-xs text-[var(--text-dim)]">Enable or mute synthesized UI telemetry audio</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--cyan)]">AUDIO</span>
      </li>

      <li data-cmd-item data-type="action" data-action="toggle-motion" data-keywords="reduce motion accessibility animations stop" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="eye" class="w-4 h-4 text-white"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Action // Toggle Reduced Motion</p>
            <p class="text-xs text-[var(--text-dim)]">Switch between full cinema motion and accessible static mode</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-white/60">A11Y</span>
      </li>

      <li data-cmd-item data-type="action" data-action="konami-glitch" data-keywords="glitch konami easter egg overdrive hack matrix" role="option" tabindex="-1" class="cmd-row flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
        <div class="flex items-center gap-3">
          <i data-lucide="zap" class="w-4 h-4 text-[var(--danger)]"></i>
          <div>
            <p class="font-mono text-xs font-semibold text-white uppercase tracking-wider">Easter Egg // Toggle Konami Glitch Overdrive</p>
            <p class="text-xs text-[var(--text-dim)]">Activate RGB-split shader distortion &amp; intruder alert</p>
          </div>
        </div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-[var(--danger)]">↑↑↓↓←→←→BA</span>
      </li>
    </ul>

    <!-- Footer Help Bar -->
    <div class="flex items-center justify-between px-5 py-3 border-t border-white/10 bg-[#05060A]/90 font-mono text-[10px] tracking-[0.15em] uppercase text-[var(--text-dim)]">
      <span>↑↓ NAVIGATE · ↵ SELECT · ESC CLOSE</span>
      <span class="text-[var(--acid)]">MABDEIRA.DEV // COMMAND OS</span>
    </div>
  </div>
</div>

