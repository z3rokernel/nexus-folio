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
        <span class="text-white/75">MOSTEPHA AMINE BDEIRA // LYON, FRANCE</span>
      </div>

      <h1
        data-split="chars"
        aria-label="MOSTEPHA AMINE BDEIRA — FULL-STACK DEVELOPER & QA ENGINEER"
        class="font-display section-display-size font-black uppercase tracking-tight text-white"
      >
        8+ YEARS BUILDING <span class="text-chrome">ROBUST</span> WEB &amp; SQL SYSTEMS.
      </h1>

      <div class="space-y-5 text-base sm:text-lg text-[var(--text-dim)] leading-relaxed">
        <p>
          I’m <strong class="text-white"><?= esc($site['name'] ?? 'Mostepha Amine Bdeira') ?></strong>, a Full-Stack Web Developer and QA Specialist based in <span class="text-white"><?= esc($site['city'] ?? 'Lyon, France') ?></span> with over <strong class="text-[var(--acid)]">8 years of freelance experience</strong> and more than <strong class="text-white">30 custom web projects delivered</strong> for SMBs, e-commerce brands, and associations.
        </p>
        <p>
          I specialize in end-to-end web engineering: gathering business requirements, designing normalized <strong class="text-[var(--acid)]">MySQL and PostgreSQL</strong> databases, building clean MVC backends with <strong class="text-white">PHP, CodeIgniter 4, and Laravel</strong>, and crafting responsive interfaces with <strong class="text-[var(--cyan)]">Tailwind CSS and JavaScript</strong>.
        </p>
        <p>
          Every system I deliver is backed by rigorous <em class="text-white">REST API testing (Postman), automated unit/feature tests (PHPUnit), custom debugging scripts, and Linux production deployment</em>. I hold a <strong class="text-white">Master’s degree in Intelligent Computer Systems</strong> (officially recognized Level 7 in France by ENIC-NARIC), with a thesis focused on Deep Learning and AI-assisted e-learning.
        </p>
      </div>

      <div class="flex flex-wrap items-center gap-4 pt-2">
        <?= view('components/button', [
            'label'   => 'EXPERIENCE & EDUCATION',
            'href'    => '#experience-timeline',
            'primary' => true,
            'icon'    => 'graduation-cap',
            'cursor'  => 'link',
        ]) ?>
        <?= view('components/button', [
            'label'   => 'CONTACT ME',
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
        'title'    => 'MABDEIRA.DEV TERMINAL',
        'subtitle' => 'Execute live commands below: try help, whoami, skills, projects, education, contact, theme acid|plasma|cyan, or clear.',
    ]) ?>

    <div class="glass-card border border-[var(--acid)]/35 overflow-hidden shadow-[0_25px_80px_rgba(0,0,0,0.85)]">
      <!-- Terminal Window Bar -->
      <div class="flex items-center justify-between px-5 py-3.5 bg-[#0B0D14] border-b border-white/10 font-mono text-xs">
        <div class="flex items-center gap-2">
          <span class="w-3 h-3 rounded-full bg-[#FF3B5C]"></span>
          <span class="w-3 h-3 rounded-full bg-[#F59E0B]"></span>
          <span class="w-3 h-3 rounded-full bg-[#D4FF1F]"></span>
          <span class="ml-3 text-white/80 tracking-wider">amine@mabdeira.dev: ~/portfolio</span>
        </div>
        <div class="flex items-center gap-2">
          <button type="button" data-term-quick="whoami" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">whoami</button>
          <button type="button" data-term-quick="exp" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">exp</button>
          <button type="button" data-term-quick="skills" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">skills</button>
          <button type="button" data-term-quick="projects" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">projects</button>
          <button type="button" data-term-quick="bgm" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">bgm</button>
          <button type="button" data-term-quick="help" class="px-2 py-0.5 rounded bg-white/5 hover:bg-[var(--acid)] hover:text-[var(--void)] text-[10px] text-[var(--acid)] transition-colors">help</button>
        </div>
      </div>

      <!-- Terminal Output Log -->
      <div
        id="about-terminal-output"
        class="p-6 font-mono text-xs sm:text-sm leading-relaxed space-y-3 h-[340px] overflow-y-auto bg-[#05060A]/95 text-white/90"
        aria-live="polite"
      >
        <div class="text-[var(--text-dim)]">// MABDEIRA.DEV INTERACTIVE SHELL — SESSION INITIALIZED</div>
        <div><span class="text-[var(--acid)]">amine@mabdeira.dev:~$</span> <span class="text-white">whoami</span></div>
        <div class="text-[var(--cyan)] pl-4">Mostepha Amine Bdeira — Full-Stack Web Developer (8+ yrs, 30+ projects) &amp; QA Specialist in Lyon, France. Master in Intelligent Computer Systems (Level 7).</div>
        <div><span class="text-[var(--acid)]">amine@mabdeira.dev:~$</span> <span class="text-white">cat skills.txt</span></div>
        <div class="text-white/80 pl-4">[Backend &amp; DB] PHP, CodeIgniter 4, Laravel, SQL, MySQL, PostgreSQL, REST APIs · [QA] Postman, PHPUnit, Debugging · [Frontend] Tailwind CSS, JS, HTML5/CSS3</div>
        <div class="text-[var(--text-dim)]">// Type <span class="text-[var(--acid)]">help</span> and press Enter to explore interactive commands.</div>
      </div>

      <!-- Terminal Prompt Input -->
      <form id="about-terminal-form" class="flex items-center gap-3 px-6 py-4 bg-[#0B0D14]/90 border-t border-white/10 font-mono text-sm">
        <label for="about-terminal-input" class="text-[var(--acid)] shrink-0 font-semibold">amine@mabdeira.dev:~$</label>
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
       SECTION 03 // EXPERIENCE & EDUCATION TIMELINE + LIVE WIDGET
       =================================================================== -->
  <section id="experience-timeline" data-scene="03" data-scene-label="EXPERIENCE & STUDIES" class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start scroll-mt-28">
    <div class="lg:col-span-8 space-y-10">
      <?= view('components/section-title', [
          'index'    => '03',
          'label'    => 'EXPERIENCE & ACADEMIC STUDIES',
          'title'    => 'CAREER & EDUCATION',
          'subtitle' => '8+ years of Full-Stack freelance engineering and university degrees in Intelligent Computer Systems (Master Level 7).',
      ]) ?>

      <div class="space-y-6">
        <?php foreach ($experiences as $exp): ?>
          <?php
            $isEdu = str_contains(strtolower($exp['role'] . ' ' . $exp['company']), 'master')
                  || str_contains(strtolower($exp['role'] . ' ' . $exp['company']), 'licence')
                  || str_contains(strtolower($exp['role'] . ' ' . $exp['company']), 'université');
          ?>
          <article class="glass-card p-7 sm:p-8 border border-white/15 hover:border-[var(--acid)] transition-colors space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
              <div class="flex items-center gap-2.5">
                <span class="px-2.5 py-0.5 rounded-full font-mono text-[10px] tracking-[0.16em] uppercase <?= $isEdu ? 'bg-[var(--cyan)]/15 text-[var(--cyan)] border border-[var(--cyan)]/40' : 'bg-[var(--acid)]/15 text-[var(--acid)] border border-[var(--acid)]/40' ?>">
                  <?= $isEdu ? 'ACADEMIC STUDY' : 'EXPERIENCE' ?>
                </span>
                <span class="font-mono text-xs tracking-[0.18em] uppercase text-[var(--acid)]">
                  <?= esc($exp['start']) ?> — <?= esc($exp['end']) ?>
                </span>
              </div>
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
            <span class="text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">EDUCATION (LEVEL 7)</span>
            <p class="text-xs sm:text-sm text-white/90"><?= esc($currently['education']) ?></p>
          </div>
          <div class="space-y-1">
            <span class="text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">LANGUAGES</span>
            <p class="text-xs sm:text-sm text-white/80"><?= esc($currently['languages']) ?></p>
          </div>
        </div>
      </div>
    </aside>
  </section>

</div>

<?= $this->endSection() ?>

