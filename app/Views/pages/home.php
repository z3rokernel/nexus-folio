<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Home Experience — 9 Cinematic Scenes
 * @var array<string, mixed> $site
 * @var array<int, array<string, mixed>> $featuredProjects
 * @var array<int, array<string, mixed>> $skills
 * @var array<string, array<int, array<string, mixed>>> $groupedSkills
 * @var array<int, array<string, mixed>> $stats
 * @var array<int, array<string, mixed>> $capabilities
 * @var array<int, array<string, mixed>> $processSteps
 */
?>

<!-- =====================================================================
     SCENE 01 // HERO — LIQUID SHADER STAGE
     ===================================================================== -->
<section
  id="scene-hero"
  data-scene="01"
  data-scene-label="HERO STAGE"
  class="relative min-h-[100svh] flex flex-col justify-center pt-28 pb-20 px-6 sm:px-10 lg:px-16 overflow-hidden"
>
  <div class="max-w-[1750px] mx-auto w-full relative z-10 space-y-10">

    <!-- Top Studio Telemetry Pill + Rotating Role Badge -->
    <div class="flex flex-wrap items-center gap-4">
      <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-[#0B0D14]/85 backdrop-blur-md border border-[var(--acid)]/40 font-mono text-xs tracking-[0.18em] uppercase text-[var(--acid)]">
        <span class="w-2 h-2 rounded-full bg-[var(--acid)] animate-ping"></span>
        <span>INITIALIZING // SCENE 01</span>
      </div>

      <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 backdrop-blur-md border border-white/10 font-mono text-xs tracking-[0.16em] uppercase text-white/90">
        <span class="text-[var(--text-dim)]">ROLE:</span>
        <span
          id="hero-rotating-role"
          data-roles='<?= json_encode($site["roles"] ?? ["Full-Stack Developer", "Creative Technologist", "AI Builder"]) ?>'
          class="text-[var(--cyan)] font-semibold"
        >Full-Stack Developer</span>
      </div>
    </div>

    <!-- Giant Kinetic Headline (SplitText Chars + Chrome Shine Sweep) -->
    <div class="space-y-3">
      <h1
        id="hero-headline"
        aria-label="<?= esc($site['name'] ?? 'MOSTEPHA AMINE BDEIR') ?> — ARCHITECTING CINEMATIC AI & WEBGL SYSTEMS"
        class="font-display hero-display-size font-black uppercase tracking-tight text-white"
      >
        <span data-hero-split class="block">ARCHITECTING</span>
        <span class="block text-chrome">LIQUID INTELLIGENCE</span>
        <span data-hero-split class="block text-white/90">&amp; NEXT-GEN WEB.</span>
      </h1>
    </div>

    <!-- Sub-copy + Magnetic CTAs + Live Telemetry Card -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end pt-2">
      <div class="lg:col-span-7 space-y-8">
        <p
          id="hero-subcopy"
          class="text-lg sm:text-xl lg:text-2xl text-[var(--text-dim)] max-w-2xl leading-relaxed font-normal"
        >
          I’m <strong class="text-white font-semibold"><?= esc($site['name'] ?? 'Mostepha Amine BDEIR') ?></strong> — designing &amp; engineering high-velocity digital products where <span class="text-[var(--acid)]">CodeIgniter 4</span> precision meets <span class="text-white">real-time GLSL shaders</span> and <span class="text-[var(--cyan)]">agentic AI workflows</span>.
        </p>

        <!-- Primary & Secondary Magnetic CTAs -->
        <div class="flex flex-wrap items-center gap-4">
          <?= view('components/button', [
              'label'   => 'VIEW SELECTED WORK',
              'href'    => base_url('work'),
              'primary' => true,
              'icon'    => 'film',
              'cursor'  => 'view',
          ]) ?>
          <?= view('components/button', [
              'label'   => '> HIRE_ME --NOW',
              'href'    => base_url('contact'),
              'primary' => false,
              'icon'    => 'terminal',
              'cursor'  => 'link',
          ]) ?>
        </div>
      </div>

      <!-- Right Studio Telemetry Readout -->
      <div class="lg:col-span-5 flex lg:justify-end">
        <div class="glass-card p-5 sm:p-6 max-w-sm w-full space-y-3 border border-white/15">
          <div class="flex items-center justify-between font-mono text-[11px] tracking-[0.18em] text-[var(--acid)] uppercase">
            <span>// VIEWPORT SHADER</span>
            <span>60.0 FPS LOCKED</span>
          </div>
          <p class="font-mono text-xs text-[var(--text-dim)] leading-relaxed">
            Domain-warped FBM liquid field + interactive pointer ripple. Move cursor or scroll to modulate uniform state.
          </p>
          <div class="pt-2 border-t border-white/10 flex items-center justify-between font-mono text-[10px] tracking-[0.16em] text-white/70 uppercase">
            <span>LOC: <?= esc($site['city'] ?? 'Paris, France') ?></span>
            <span class="text-emerald-400">● ONLINE</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- =====================================================================
     SCENE 02 // INTRO STATEMENT — WORD-BY-WORD SCRUB REVEAL
     ===================================================================== -->
<section
  id="scene-intro"
  data-scene="02"
  data-scene-label="MANIFESTO"
  class="relative py-28 sm:py-36 px-6 sm:px-10 lg:px-16 border-t border-white/10 bg-[#05060A]/75 backdrop-blur-sm"
>
  <div class="max-w-[1500px] mx-auto space-y-8">
    <div class="inline-flex items-center gap-3 font-mono text-xs tracking-[0.22em] uppercase text-[var(--acid)]">
      <span>02 //</span>
      <span class="h-px w-8 bg-[var(--acid)]/50"></span>
      <span class="text-white/75">DIRECTOR’S STATEMENT</span>
    </div>

    <p
      id="scrub-manifesto"
      class="font-display text-2xl sm:text-4xl lg:text-5xl font-bold leading-[1.22] tracking-tight text-white uppercase"
    >
      THE MODERN WEB SHOULD NOT FEEL LIKE STATIC PAPERWORK. WE BUILD <span class="text-[var(--acid)]">SENSORY SOFTWARE</span> — INTERFACES THAT RESPOND TO VELOCITY, RESPECT <span class="text-[var(--cyan)]">ACCESSIBILITY</span>, DELIVER <span class="text-[var(--acid)]">SUB-SECOND PERFORMANCE</span>, AND TURN COMPLEX AI &amp; DATA SYSTEMS INTO CINEMA.
    </p>
  </div>
</section>

<!-- =====================================================================
     SCENE 03 // SIGNATURE PROJECT REEL (PINNED HORIZONTAL REEL ON DESKTOP)
     ===================================================================== -->
<section
  id="scene-reel"
  data-scene="03"
  data-scene-label="PROJECT REEL"
  tabindex="0"
  aria-label="Featured Projects Timeline Reel (Use Left and Right Arrow keys to navigate scenes)"
  class="relative py-24 lg:py-0 lg:min-h-screen border-t border-white/10 overflow-hidden focus:outline-none"
>
  <div id="reel-pin-wrap" class="lg:h-screen flex flex-col justify-between py-12 lg:py-20 px-6 sm:px-10 lg:px-16 max-w-[1850px] mx-auto">

    <!-- Reel Header + Scene Counter + Progress Track -->
    <div class="flex flex-wrap items-end justify-between gap-6 pb-8">
      <div>
        <div class="inline-flex items-center gap-3 font-mono text-xs tracking-[0.22em] uppercase text-[var(--acid)] mb-2">
          <span>03 //</span>
          <span class="h-px w-8 bg-[var(--acid)]/50"></span>
          <span class="text-white/75">FEATURED TIMELINE SCENES</span>
        </div>
        <h2 class="font-display text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-white">
          SELECTED PRODUCTIONS
        </h2>
      </div>

      <div class="flex items-center gap-6">
        <div class="font-mono text-xs tracking-[0.2em] uppercase">
          <span class="text-[var(--text-dim)]">REEL</span>
          <span id="reel-counter" class="text-[var(--acid)] font-bold ml-2 tabular-nums">SCENE 01 / 0<?= count($featuredProjects) ?></span>
        </div>
        <div class="hidden sm:block w-36 h-1 bg-white/10 rounded-full overflow-hidden">
          <div id="reel-progress-bar" class="h-full bg-[var(--acid)] w-1/6"></div>
        </div>
        <a href="<?= base_url('work') ?>" data-cursor="link" class="font-mono text-xs tracking-[0.18em] uppercase text-white hover:text-[var(--acid)] transition-colors">
          ALL ARCHIVES (<?= count($featuredProjects) ?>) →
        </a>
      </div>
    </div>

    <!-- Horizontal Track on Desktop / Vertical Stack on Mobile -->
    <div
      id="reel-track"
      class="flex flex-col lg:flex-row items-stretch gap-8 lg:gap-12 will-change-transform"
    >
      <?php foreach ($featuredProjects as $idx => $proj):
          $sceneNum = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
          $tags     = $proj['tags'] ?? [];
          $stack    = array_slice($proj['stack'] ?? [], 0, 4);
      ?>
        <article
          data-reel-card
          data-index="<?= $idx ?>"
          data-slug="<?= esc($proj['slug']) ?>"
          data-cursor="view"
          class="group relative lg:w-[68vw] xl:w-[58vw] shrink-0 glass-card p-6 sm:p-8 lg:p-10 flex flex-col justify-between gap-6 border border-white/15"
        >
          <!-- Top Scene Number & Client -->
          <div class="flex items-center justify-between gap-4 font-mono text-xs tracking-[0.2em] uppercase">
            <span class="px-3 py-1 rounded-full bg-[var(--acid)]/15 text-[var(--acid)] border border-[var(--acid)]/40 font-bold">
              SCENE <?= esc($sceneNum) ?> // <?= esc((string) $proj['year']) ?>
            </span>
            <span class="text-[var(--text-dim)]"><?= esc($proj['client']) ?> · <?= esc($proj['role']) ?></span>
          </div>

          <!-- Interactive Media Plane + Outlined Title Overlay -->
          <a
            href="<?= base_url('work/' . $proj['slug']) ?>"
            data-flip-id="project-media-<?= esc($proj['slug']) ?>"
            class="relative block aspect-[16/9] rounded-xl overflow-hidden bg-[#07090F] border border-white/10"
          >
            <img
              src="<?= base_url(ltrim((string) $proj['cover_image'], '/')) ?>"
              alt="<?= esc($proj['title']) ?> — <?= esc($proj['subtitle']) ?>"
              width="1280"
              height="720"
              loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>"
              data-reel-img
              class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-[#05060A] via-[#05060A]/30 to-transparent"></div>

            <!-- Giant Outlined Title inside Scene Frame -->
            <div class="absolute bottom-4 left-5 right-5 flex items-end justify-between gap-4">
              <div>
                <h3 class="font-display text-3xl sm:text-5xl font-black uppercase tracking-tight text-stroke group-hover:text-[var(--acid)]">
                  <?= esc($proj['title']) ?>
                </h3>
                <p class="text-sm sm:text-base text-white/90 mt-1 max-w-xl">
                  <?= esc($proj['subtitle']) ?>
                </p>
              </div>
              <span class="hidden sm:inline-flex items-center justify-center w-12 h-12 rounded-full bg-[var(--acid)] text-[var(--void)] shrink-0 group-hover:scale-110 transition-transform">
                <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
              </span>
            </div>
          </a>

          <!-- Bottom Stack & Metrics Row -->
          <div class="flex flex-wrap items-center justify-between gap-4 pt-2 border-t border-white/10">
            <div class="flex flex-wrap gap-2">
              <?php foreach ($stack as $tech): ?>
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 font-mono text-[11px] tracking-wider text-white/80">
                  <?= esc($tech) ?>
                </span>
              <?php endforeach; ?>
            </div>
            <div class="flex items-center gap-4 font-mono text-xs text-[var(--acid)]">
              <?php if (! empty($proj['results'][0])): ?>
                <span>★ <?= esc($proj['results'][0]) ?></span>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- =====================================================================
     SCENE 04 // VELOCITY-REACTIVE INFINITE TECH MARQUEE
     ===================================================================== -->
<section
  id="scene-marquee"
  data-scene="04"
  data-scene-label="TECH STACK"
  aria-label="Technology Stack Ticker"
  class="relative py-14 border-y border-white/10 bg-[#0B0D14]/90 overflow-hidden select-none"
>
  <div class="space-y-5">
    <!-- Row 1 (Left) -->
    <div class="flex whitespace-nowrap overflow-hidden">
      <div data-marquee-row="1" class="flex items-center gap-10 pr-10 font-display text-2xl sm:text-4xl font-extrabold uppercase tracking-tight text-white/85">
        <span>CODEIGNITER 4.7</span><span class="text-[var(--acid)]">✦</span>
        <span>THREE.JS WEBGL2</span><span class="text-[var(--cyan)]">✦</span>
        <span>GSAP 3.13 + SCROLLTRIGGER</span><span class="text-[var(--acid)]">✦</span>
        <span>CUSTOM GLSL SHADERS</span><span class="text-[var(--plasma)]">✦</span>
        <span>TAILWIND CSS V4</span><span class="text-[var(--acid)]">✦</span>
        <span>PHP 8.3 STRICT TYPES</span><span class="text-[var(--cyan)]">✦</span>
        <span>CODEIGNITER 4.7</span><span class="text-[var(--acid)]">✦</span>
        <span>THREE.JS WEBGL2</span><span class="text-[var(--cyan)]">✦</span>
        <span>GSAP 3.13 + SCROLLTRIGGER</span><span class="text-[var(--acid)]">✦</span>
        <span>CUSTOM GLSL SHADERS</span><span class="text-[var(--plasma)]">✦</span>
      </div>
    </div>

    <!-- Row 2 (Right) -->
    <div class="flex whitespace-nowrap overflow-hidden">
      <div data-marquee-row="-1" class="flex items-center gap-10 pr-10 font-mono text-sm sm:text-base tracking-[0.25em] uppercase text-[var(--text-dim)]">
        <span>BARBA.JS TRANSITIONS</span><span class="text-[var(--acid)]">//</span>
        <span>LENIS SMOOTH SCROLL</span><span class="text-[var(--cyan)]">//</span>
        <span>MULTI-AGENT RAG PIPELINES</span><span class="text-[var(--acid)]">//</span>
        <span>MATTER.JS 2D PHYSICS</span><span class="text-[var(--plasma)]">//</span>
        <span>WEBAUDIO SYNTH DSP</span><span class="text-[var(--acid)]">//</span>
        <span>DOCKER + GITHUB ACTIONS CI</span><span class="text-[var(--cyan)]">//</span>
        <span>BARBA.JS TRANSITIONS</span><span class="text-[var(--acid)]">//</span>
        <span>LENIS SMOOTH SCROLL</span><span class="text-[var(--cyan)]">//</span>
        <span>MULTI-AGENT RAG PIPELINES</span><span class="text-[var(--acid)]">//</span>
        <span>MATTER.JS 2D PHYSICS</span><span class="text-[var(--plasma)]">//</span>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================================
     SCENE 05 // CAPABILITIES — 4 GLASS 3D TILT CARDS
     ===================================================================== -->
<section
  id="scene-capabilities"
  data-scene="05"
  data-scene-label="CAPABILITIES"
  class="relative py-28 sm:py-36 px-6 sm:px-10 lg:px-16"
>
  <div class="max-w-[1700px] mx-auto space-y-16">
    <?= view('components/section-title', [
        'index'    => '05',
        'label'    => 'SYSTEM ARCHITECTURE & CRAFT',
        'title'    => 'CORE CAPABILITIES',
        'subtitle' => 'Full-spectrum execution from database schema and security filters up to custom fragment shaders and 60fps interaction choreography.',
    ]) ?>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 sm:gap-8">
      <?php foreach ($capabilities as $cap): ?>
        <article
          data-tilt
          data-reveal
          class="tilt-card glass-card p-7 sm:p-8 flex flex-col justify-between gap-8 group"
        >
          <div class="tilt-glare" aria-hidden="true"></div>

          <div class="space-y-6">
            <div class="flex items-center justify-between">
              <span class="font-mono text-xs tracking-[0.2em] text-[var(--acid)]"><?= esc($cap['index']) ?> // MODULE</span>
              <div class="w-11 h-11 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[var(--acid)] group-hover:bg-[var(--acid)] group-hover:text-[var(--void)] transition-colors">
                <i data-lucide="<?= esc($cap['icon']) ?>" class="w-5 h-5"></i>
              </div>
            </div>

            <div class="space-y-2">
              <p class="font-mono text-[11px] tracking-[0.15em] uppercase text-[var(--cyan)]"><?= esc($cap['tag']) ?></p>
              <h3 class="font-display text-xl sm:text-2xl font-bold text-white uppercase tracking-tight">
                <?= esc($cap['title']) ?>
              </h3>
            </div>

            <p class="text-sm sm:text-base text-[var(--text-dim)] leading-relaxed">
              <?= esc($cap['summary']) ?>
            </p>
          </div>

          <ul class="space-y-2 pt-5 border-t border-white/10 font-mono text-xs text-white/80">
            <?php foreach ($cap['bullets'] as $b): ?>
              <li class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[var(--acid)]"></span>
                <span><?= esc($b) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =====================================================================
     SCENE 06 // SKILLS PHYSICS PLAYGROUND (MATTER.JS + ACCESSIBLE FALLBACK)
     ===================================================================== -->
<section
  id="scene-skills"
  data-scene="06"
  data-scene-label="SKILLS ARENA"
  class="relative py-28 px-6 sm:px-10 lg:px-16 border-t border-white/10 bg-[#0B0D14]/60"
>
  <div class="max-w-[1700px] mx-auto space-y-12">
    <div class="flex flex-wrap items-end justify-between gap-6">
      <?= view('components/section-title', [
          'index'    => '06',
          'label'    => 'INTERACTIVE RIGID-BODY SANDBOX',
          'title'    => 'SKILLS PLAYGROUND',
          'subtitle' => 'Grab, throw, and collide tech stack modules inside the 2D physics chamber—or inspect the structured capability matrix below.',
      ]) ?>

      <button
        type="button"
        id="physics-gravity-btn"
        data-magnetic
        data-cursor="link"
        class="btn-nexus"
      >
        <span class="btn-fill"></span>
        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
        <span>IMPULSE GRAVITY</span>
      </button>
    </div>

    <!-- Interactive Matter.js Arena -->
    <div
      id="skills-physics-arena"
      data-cursor="drag"
      data-skills='<?= esc(json_encode(array_map(fn($s) => ["name" => $s["name"], "category" => $s["category"], "level" => $s["level"]], $skills))) ?>'
      class="relative w-full h-[380px] sm:h-[440px] rounded-3xl glass-card border border-white/15 overflow-hidden bg-[#05060A]/90"
      aria-label="Interactive 2D Physics Skills Playground"
    >
      <canvas id="skills-physics-canvas" class="w-full h-full block" aria-hidden="true"></canvas>
      <div class="absolute top-4 left-5 pointer-events-none font-mono text-[11px] tracking-[0.18em] uppercase text-[var(--text-dim)]">
        <span class="text-[var(--acid)]">● MATTER.JS ENGINE</span> // DRAG &amp; THROW NODES
      </div>
    </div>

    <!-- Accessible Static Tag Cloud (Always present for screen readers, no-JS, and reduced-motion) -->
    <div class="flex flex-wrap gap-2.5 pt-2" aria-label="Complete Skills List">
      <?php foreach ($skills as $sk): ?>
        <?= view('components/skill-chip', [
            'name'     => $sk['name'],
            'category' => $sk['category'],
            'level'    => $sk['level'],
        ]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =====================================================================
     SCENE 07 // LIVE TELEMETRY STATS & GITHUB CONTRIBUTION HEAT-GRID
     ===================================================================== -->
<section
  id="scene-stats"
  data-scene="07"
  data-scene-label="GITHUB TELEMETRY"
  class="relative py-28 px-6 sm:px-10 lg:px-16 border-t border-white/10"
>
  <div class="max-w-[1700px] mx-auto space-y-14">
    <?= view('components/section-title', [
        'index'    => '07',
        'label'    => 'VERIFIED OUTPUT & OPEN SOURCE',
        'title'    => 'LIVE TELEMETRY & GITHUB',
        'subtitle' => 'Cached hourly from /api/github. Move your cursor across the contribution matrix to trigger a reactive wave.',
    ]) ?>

    <!-- 4 Counter Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($stats as $st): ?>
        <?= view('components/stat', $st) ?>
      <?php endforeach; ?>
    </div>

    <!-- Interactive GitHub Contribution Heat-Grid Panel -->
    <div class="glass-card p-6 sm:p-10 border border-white/15 space-y-6">
      <div class="flex flex-wrap items-center justify-between gap-4 font-mono text-xs tracking-[0.16em] uppercase">
        <div class="flex items-center gap-3">
          <i data-lucide="git-commit" class="w-4 h-4 text-[var(--acid)]"></i>
          <span class="text-white font-semibold">GITHUB // @<?= esc($site['github_user'] ?? 'aminebdeir') ?></span>
          <span id="gh-total-badge" class="px-2.5 py-0.5 rounded-full bg-[var(--acid)]/15 text-[var(--acid)]">2,846 CONTRIBUTIONS</span>
        </div>
        <div class="flex items-center gap-2 text-[10px] text-[var(--text-dim)]">
          <span>LESS</span>
          <span class="w-3 h-3 rounded-sm bg-white/10 inline-block"></span>
          <span class="w-3 h-3 rounded-sm bg-[#D4FF1F]/30 inline-block"></span>
          <span class="w-3 h-3 rounded-sm bg-[#D4FF1F]/60 inline-block"></span>
          <span class="w-3 h-3 rounded-sm bg-[#D4FF1F] inline-block"></span>
          <span>MORE</span>
        </div>
      </div>

      <div class="w-full overflow-x-auto">
        <canvas
          id="github-heatgrid-canvas"
          width="1120"
          height="180"
          class="w-full min-w-[680px] h-[160px] sm:h-[180px] block rounded-xl bg-[#05060A]/80 p-3 border border-white/10"
          aria-label="GitHub 52-week contribution heat grid"
        ></canvas>
      </div>
    </div>
  </div>
</section>

<!-- =====================================================================
     SCENE 08 // PROCESS TIMELINE (SVG LINE DRAW ON SCROLL)
     ===================================================================== -->
<section
  id="scene-process"
  data-scene="08"
  data-scene-label="PROCESS"
  class="relative py-28 px-6 sm:px-10 lg:px-16 border-t border-white/10 bg-[#0B0D14]/50"
>
  <div class="max-w-[1600px] mx-auto space-y-16">
    <?= view('components/section-title', [
        'index'    => '08',
        'label'    => 'EXECUTION PROTOCOL',
        'title'    => 'HOW WE SHIP',
        'subtitle' => 'A four-phase engineering protocol designed for speed, visual impact, and production resilience.',
    ]) ?>

    <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <?php foreach ($processSteps as $step): ?>
        <div data-process-step class="glass-card p-7 sm:p-8 flex flex-col justify-between gap-6 border border-white/15 relative group">
          <div class="space-y-4">
            <div class="flex items-center justify-between font-mono text-xs tracking-[0.2em]">
              <span class="px-3 py-1 rounded-full bg-[var(--acid)]/15 text-[var(--acid)] font-bold">PHASE <?= esc($step['step']) ?></span>
              <span class="text-[var(--text-dim)]"><?= esc($step['meta']) ?></span>
            </div>
            <h3 class="font-display text-xl sm:text-2xl font-bold text-white uppercase group-hover:text-[var(--acid)] transition-colors">
              <?= esc($step['name']) ?>
            </h3>
            <p class="text-sm sm:text-base text-[var(--text-dim)] leading-relaxed">
              <?= esc($step['desc']) ?>
            </p>
          </div>
          <div class="h-1 w-full bg-white/10 rounded-full overflow-hidden">
            <div class="h-full bg-[var(--acid)] w-1/4 group-hover:w-full transition-all duration-700"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =====================================================================
     SCENE 09 // CLOSING CTA WITH INTERACTIVE CURSOR LIGHT TRAIL
     ===================================================================== -->
<section
  id="scene-cta"
  data-scene="09"
  data-scene-label="TRANSMISSION"
  class="relative min-h-[82svh] flex items-center justify-center py-28 px-6 sm:px-10 lg:px-16 border-t border-white/10 overflow-hidden"
>
  <!-- Interactive Fluid Light-Trail Canvas -->
  <canvas
    id="cta-light-trail"
    class="absolute inset-0 w-full h-full pointer-events-none z-0"
    aria-hidden="true"
  ></canvas>

  <div class="relative z-10 max-w-[1500px] mx-auto text-center space-y-10">
    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/5 border border-[var(--acid)]/40 font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">
      <span class="w-2 h-2 rounded-full bg-[var(--acid)] animate-ping"></span>
      <span>09 // READY FOR NEXT PRODUCTION</span>
    </div>

    <h2
      data-split="chars"
      aria-label="LET'S BUILD SOMETHING IMPOSSIBLE"
      class="font-display text-[clamp(2.4rem,7.2vw,7.8rem)] font-black leading-[0.92] tracking-tight uppercase text-white"
    >
      LET’S BUILD SOMETHING <span class="text-[var(--acid)]">IMPOSSIBLE.</span>
    </h2>

    <p class="text-lg sm:text-xl text-[var(--text-dim)] max-w-2xl mx-auto">
      Available for flagship product builds, creative WebGL direction, AI systems architecture, and technical consulting.
    </p>

    <div class="flex flex-wrap items-center justify-center gap-5 pt-2">
      <?= view('components/button', [
          'label'   => 'START A TRANSMISSION',
          'href'    => base_url('contact'),
          'primary' => true,
          'icon'    => 'send',
          'cursor'  => 'link',
      ]) ?>

      <button
        type="button"
        data-copy-email="<?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?>"
        data-magnetic
        data-cursor="copy"
        class="btn-nexus"
      >
        <span class="btn-fill"></span>
        <i data-lucide="copy" class="w-4 h-4"></i>
        <span>COPY <?= esc($site['email'] ?? 'contact@nexus-folio.dev') ?></span>
      </button>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
