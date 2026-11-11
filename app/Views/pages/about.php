<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * About Page (/about) — Duotone Portrait, Interactive Terminal, Experience Timeline & Currently Widget
 * @var array<string, mixed> $site
 * @var array<int, array<string, mixed>> $experiences
 * @var array<string, array<int, array<string, mixed>>> $groupedSkills
 * @var array<int, array<string, mixed>> $projects
 * @var array<string, string> $currently
 */
?>

<div class="pt-32 pb-28 px-6 sm:px-10 lg:px-16 max-w-[1700px] mx-auto space-y-28">

  <!-- ===================================================================
       SECTION 01 // BIO & DUOTONE CYBERNETIC PORTRAIT
       =================================================================== -->
  <section data-scene="01" data-scene-label="BIO & PORTRAIT" class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
    <!-- Portrait Column -->
    <div class="lg:col-span-5">
      <div
        data-tilt
        class="tilt-card glass-card p-4 border border-white/15 relative group overflow-hidden"
      >
        <div class="tilt-glare" aria-hidden="true"></div>
        <div class="aspect-[9/11] rounded-2xl overflow-hidden bg-[#07090F] relative">
          <img
            src="<?= base_url('assets/img/portrait.svg') ?>"
            alt="Portrait of <?= esc($site['name'] ?? 'Mostepha Amine BDEIR') ?>"
            width="900"
            height="1100"
            class="w-full h-full object-cover filter contrast-110 group-hover:hue-rotate-30 transition-all duration-700"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-[#05060A] via-transparent to-transparent opacity-70"></div>
          <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between font-mono text-[11px] tracking-[0.16em] uppercase text-[var(--acid)] bg-black/75 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/10">
            <span>OPERATOR // <?= esc($site['name'] ?? 'MOSTEPHA AMINE BDEIR') ?></span>
            <span>● VERIFIED</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bio Narrative Column -->
    <div class="lg:col-span-7 space-y-8">
      <div class="inline-flex items-center gap-3 font-mono text-xs tracking-[0.22em] uppercase text-[var(--acid)]">
        <span>01 //</span>
        <span class="h-px w-8 bg-[var(--acid)]/50"></span>
        <span class="text-white/75">OPERATOR DOSSIER</span>
      </div>

      <h1
        data-split="chars"
        aria-label="ENGINEERING WHERE CINEMA MEETS SYSTEMS ARCHITECTURE"
        class="font-display section-display-size font-black uppercase tracking-tight text-white"
      >
        WHERE <span class="text-chrome">CINEMA</span> MEETS SYSTEMS ARCHITECTURE.
      </h1>

      <div class="space-y-5 text-base sm:text-lg text-[var(--text-dim)] leading-relaxed">
        <p>
          I’m <strong class="text-white"><?= esc($site['name'] ?? 'Mostepha Amine BDEIR') ?></strong>, a Full-Stack Architect, Creative Technologist, and AI Systems Builder based in <span class="text-white"><?= esc($site['city'] ?? 'Paris, France') ?></span>.
        </p>
        <p>
          Over the past 6+ years, I have specialized in bridging two disciplines that rarely talk to each other: <strong class="text-[var(--acid)]">rigorous backend software engineering</strong> (PHP 8.3, CodeIgniter 4, distributed data pipelines, strict security) and <strong class="text-[var(--cyan)]">avant-garde interactive motion</strong> (custom GLSL shaders, Three.js, 60fps GSAP choreography).
        </p>
        <p>
          Whether launching a real-time generative video studio or a high-concurrency telemetry cockpit, my rule is non-negotiable: <em class="text-white">every frame must feel alive, and every endpoint must be rock-solid.</em>
        </p>
      </div>

      <div class="flex flex-wrap items-center gap-4 pt-2">
        <?= view('components/button', [
            'label'   => 'DOWNLOAD CV (PDF)',
            'href'    => base_url('cv.pdf'),
            'primary' => true,
            'icon'    => 'file-down',
            'cursor'  => 'link',
        ]) ?>
        <?= view('components/button', [
            'label'   => 'INITIATE CONTACT',
            'href'    => base_url('contact'),
            'primary' => false,
            'icon'    => 'send',
            'cursor'  => 'link',
        ]) ?>
      </div>
    </div>
  </section>

  <!-- ===================================================================
       SECTION 02 // INTERACTIVE TERMINAL (docs/03 §10.9)
       =================================================================== -->
  <section data-scene="02" data-scene-label="INTERACTIVE CLI" class="space-y-8">
    <?= view('components/section-title', [
        'index'    => '02',
        'label'    => 'INTERACTIVE SHELL // TYPE HELP',
        'title'    => 'NEXUS TERMINAL OS',
        'subtitle' => 'Execute live commands below: try help, whoami, skills, projects, contact, theme acid|plasma|cyan, or clear.',
    ]) ?>

    <div class="glass-card border border-[var(--acid)]/35 overflow-hidden shadow-[0_25px_80px_rgba(0,0,0,0.85)]">
      <!-- Terminal Window Bar -->
      <div class="flex items-center justify-between px-5 py-3.5 bg-[#0B0D14] border-b border-white/10 font-mono text-xs">
        <div class="flex items-center gap-2">
          <span class="w-3 h-3 rounded-full bg-[#FF3B5C]"></span>
          <span class="w-3 h-3 rounded-full bg-[#F59E0B]"></span>
          <span class="w-3 h-3 rounded-full bg-[#D4FF1F]"></span>
          <span class="ml-3 text-white/80 tracking-wider">amine@nexus-folio: ~/studio</span>
        </div>
        <div class="flex items-center gap-2">
          <button type="button" data-term-quick="whoami" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">whoami</button>
          <button type="button" data-term-quick="skills" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">skills</button>
          <button type="button" data-term-quick="projects" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">projects</button>
          <button type="button" data-term-quick="help" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">help</button>
        </div>
      </div>

      <!-- Terminal Output Log -->
      <div
        id="about-terminal-output"
        class="p-6 font-mono text-xs sm:text-sm leading-relaxed space-y-3 h-[340px] overflow-y-auto bg-[#05060A]/95 text-white/90"
        aria-live="polite"
      >
        <div class="text-[var(--text-dim)]">// NEXUS-FOLIO INTERACTIVE SHELL v4.2 — SESSION INITIALIZED</div>
        <div><span class="text-[var(--acid)]">amine@nexus:~$</span> <span class="text-white">whoami</span></div>
        <div class="text-[var(--cyan)] pl-4">Mostepha Amine BDEIR — Principal Creative Technologist, Full-Stack Architect (PHP/CI4) &amp; WebGL/AI Builder.</div>
        <div><span class="text-[var(--acid)]">amine@nexus:~$</span> <span class="text-white">cat skills.txt</span></div>
        <div class="text-white/80 pl-4">[Backend] PHP 8.3, CodeIgniter 4, SQLite/MySQL, Redis · [Frontend] Three.js, GLSL, GSAP 3.13, Tailwind v4 · [AI] RAG, Agents, WebAudio DSP</div>
        <div class="text-[var(--text-dim)]">// Type <span class="text-[var(--acid)]">help</span> and press Enter to explore interactive commands.</div>
      </div>

      <!-- Terminal Prompt Input -->
      <form id="about-terminal-form" class="flex items-center gap-3 px-6 py-4 bg-[#0B0D14]/90 border-t border-white/10 font-mono text-sm">
        <label for="about-terminal-input" class="text-[var(--acid)] shrink-0 font-semibold">amine@nexus:~$</label>
        <input
          type="text"
          id="about-terminal-input"
          placeholder="Type command (help, whoami, skills, projects, theme plasma, clear)…"
          autocomplete="off"
          class="w-full bg-transparent text-white placeholder-[var(--text-dim)] focus:outline-none"
        >
        <button type="submit" class="px-3 py-1 rounded bg-[var(--acid)] text-[var(--void)] font-bold text-xs uppercase tracking-wider">RUN</button>
      </form>
    </div>
  </section>

  <!-- ===================================================================
       SECTION 03 // EXPERIENCE TIMELINE & "CURRENTLY" TELEMETRY WIDGET
       =================================================================== -->
  <section data-scene="03" data-scene-label="EXPERIENCE TIMELINE" class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
    <div class="lg:col-span-8 space-y-10">
      <?= view('components/section-title', [
          'index'    => '03',
          'label'    => 'CAREER TRAJECTORY',
          'title'    => 'EXPERIENCE LOG',
      ]) ?>

      <div class="space-y-6">
        <?php foreach ($experiences as $exp): ?>
          <article class="glass-card p-7 sm:p-8 border border-white/15 hover:border-[var(--acid)] transition-colors space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
              <span class="font-mono text-xs tracking-[0.18em] uppercase text-[var(--acid)]">
                <?= esc($exp['start']) ?> — <?= esc($exp['end']) ?>
              </span>
              <span class="font-mono text-xs tracking-[0.16em] uppercase text-[var(--text-dim)]">
                <?= esc($exp['company']) ?>
              </span>
            </div>

            <h3 class="font-display text-xl sm:text-2xl font-bold uppercase text-white">
              <?= esc($exp['role']) ?>
            </h3>

            <ul class="space-y-2 text-sm sm:text-base text-[var(--text-dim)]">
              <?php foreach (($exp['bullets'] ?? []) as $bullet): ?>
                <li class="flex items-start gap-3">
                  <span class="w-1.5 h-1.5 rounded-full bg-[var(--acid)] mt-2.5 shrink-0"></span>
                  <span><?= esc($bullet) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Right Column: "Currently" Telemetry Widget -->
    <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
      <div class="glass-card p-7 sm:p-8 border border-[var(--acid)]/30 space-y-6">
        <div class="flex items-center justify-between font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">
          <span>// LIVE STATUS WIDGET</span>
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
        </div>

        <div class="space-y-5 font-mono">
          <div class="space-y-1 border-b border-white/10 pb-4">
            <span class="text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">CURRENTLY BUILDING</span>
            <p class="text-xs sm:text-sm text-white"><?= esc($currently['building']) ?></p>
          </div>
          <div class="space-y-1 border-b border-white/10 pb-4">
            <span class="text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">RESEARCHING</span>
            <p class="text-xs sm:text-sm text-[var(--cyan)]"><?= esc($currently['learning']) ?></p>
          </div>
          <div class="space-y-1 border-b border-white/10 pb-4">
            <span class="text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">STUDIO ROTATION (AUDIO)</span>
            <p class="text-xs sm:text-sm text-white/90"><?= esc($currently['listening']) ?></p>
          </div>
          <div class="space-y-1">
            <span class="text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">READING</span>
            <p class="text-xs sm:text-sm text-white/80"><?= esc($currently['reading']) ?></p>
          </div>
        </div>
      </div>
    </aside>
  </section>

</div>

<?= $this->endSection() ?>
