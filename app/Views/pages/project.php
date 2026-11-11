<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Case Study Detail Page (/work/{slug})
 * @var array<string, mixed> $site
 * @var array<string, mixed> $project
 */
$media       = $project['media'] ?? [];
$results     = $project['results'] ?? [];
$stack       = $project['stack'] ?? [];
$tags        = $project['tags'] ?? [];
$nextProject = $project['next_project'] ?? null;
?>

<article data-scene="01" data-scene-label="CASE STUDY // <?= esc($project['title']) ?>" class="pt-32 pb-20">

  <!-- Hero Header + Telemetry Meta Grid -->
  <div class="max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 space-y-12">

    <!-- Back Breadcrumb + Scene Number -->
    <div class="flex flex-wrap items-center justify-between gap-4">
      <a
        href="<?= base_url('work') ?>"
        data-magnetic
        data-cursor="link"
        class="inline-flex items-center gap-2 font-mono text-xs tracking-[0.18em] uppercase text-[var(--text-dim)] hover:text-[var(--acid)] transition-colors"
      >
        <i data-lucide="arrow-left" class="w-4 h-4 text-[var(--acid)]"></i>
        <span>BACK TO WORK ARCHIVE</span>
      </a>

      <span class="px-3.5 py-1 rounded-full bg-[var(--acid)]/15 border border-[var(--acid)]/40 font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)] font-bold">
        SCENE <?= esc($project['scene_index'] ?? '01') ?> / <?= esc($project['scene_total'] ?? '06') ?>
      </span>
    </div>

    <!-- Giant Case Study Title -->
    <div class="space-y-4">
      <h1
        data-split="chars"
        aria-label="<?= esc($project['title']) ?>"
        class="font-display hero-display-size font-black uppercase tracking-tight text-white"
      >
        <?= esc($project['title']) ?>
      </h1>
      <p class="text-xl sm:text-2xl text-[var(--text-dim)] max-w-3xl leading-relaxed">
        <?= esc($project['subtitle']) ?>
      </p>
    </div>

    <!-- Monospace Meta Grid (Role / Year / Client / Stack / Live Links) -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 p-6 sm:p-8 glass-card border border-white/15 font-mono">
      <div class="space-y-1">
        <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">01 // CLIENT</span>
        <p class="text-sm text-white font-semibold"><?= esc($project['client'] ?: 'Independent') ?></p>
      </div>
      <div class="space-y-1">
        <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">02 // ROLE</span>
        <p class="text-sm text-white font-semibold"><?= esc($project['role'] ?: 'Lead Architect') ?></p>
      </div>
      <div class="space-y-1">
        <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">03 // YEAR</span>
        <p class="text-sm text-[var(--acid)] font-semibold"><?= esc((string) $project['year']) ?></p>
      </div>
      <div class="space-y-1">
        <span class="text-[10px] tracking-[0.2em] uppercase text-[var(--text-dim)]">04 // STACK</span>
        <p class="text-xs text-white/90"><?= esc(implode(' · ', array_slice($stack, 0, 4))) ?></p>
      </div>
      <div class="col-span-2 md:col-span-1 flex items-center md:justify-end gap-3">
        <?php if (! empty($project['live_url'])): ?>
          <a
            href="<?= esc($project['live_url']) ?>"
            target="_blank"
            rel="noopener noreferrer"
            data-magnetic
            class="btn-nexus btn-nexus-primary !py-2.5 !px-4 !text-[11px]"
          >
            <span class="btn-fill"></span>
            <span>LIVE LAUNCH</span>
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
          </a>
        <?php endif; ?>
        <?php if (! empty($project['repo_url'])): ?>
          <a
            href="<?= esc($project['repo_url']) ?>"
            target="_blank"
            rel="noopener noreferrer"
            data-magnetic
            class="btn-nexus !py-2.5 !px-3.5 !text-[11px]"
            aria-label="View Source Repository"
          >
            <span class="btn-fill"></span>
            <i data-lucide="github" class="w-4 h-4"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Flip-Expanded Hero Media Stage -->
    <div
      data-flip-id="project-media-<?= esc($project['slug']) ?>"
      class="relative rounded-3xl overflow-hidden border border-white/15 shadow-[0_30px_100px_rgba(0,0,0,0.9)] bg-[#07090F] aspect-video"
    >
      <img
        src="<?= base_url(ltrim((string) $project['cover_image'], '/')) ?>"
        alt="<?= esc($project['title']) ?> Hero Viewport"
        width="1920"
        height="1080"
        class="w-full h-full object-cover"
      >
    </div>

    <!-- Impact Results Counter Strip -->
    <?php if (! empty($results)): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
        <?php foreach ($results as $idx => $res): ?>
          <div class="glass-card p-6 border border-[var(--acid)]/25 space-y-2">
            <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-[var(--acid)]">METRIC 0<?= $idx + 1 ?></span>
            <p class="font-display text-xl sm:text-2xl font-extrabold text-white uppercase"><?= esc($res) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Narrative Sections: Challenge -> Approach -> Solution -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 py-12 border-y border-white/10">
      <div class="lg:col-span-4 space-y-4">
        <span class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">01 // THE CHALLENGE</span>
        <h2 class="font-display text-2xl sm:text-3xl font-bold uppercase text-white">PROBLEM STATEMENT</h2>
        <p class="text-base sm:text-lg text-[var(--text-dim)] leading-relaxed">
          <?= esc($project['challenge']) ?>
        </p>
      </div>

      <div class="lg:col-span-4 space-y-4">
        <span class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--cyan)]">02 // ARCHITECTURE &amp; APPROACH</span>
        <h2 class="font-display text-2xl sm:text-3xl font-bold uppercase text-white">SYSTEM DESIGN</h2>
        <p class="text-base sm:text-lg text-[var(--text-dim)] leading-relaxed">
          <?= esc($project['approach']) ?>
        </p>
      </div>

      <div class="lg:col-span-4 space-y-4">
        <span class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--plasma)]">03 // THE SOLUTION</span>
        <h2 class="font-display text-2xl sm:text-3xl font-bold uppercase text-white">PRODUCTION EXECUTION</h2>
        <p class="text-base sm:text-lg text-[var(--text-dim)] leading-relaxed">
          <?= esc($project['solution']) ?>
        </p>
      </div>
    </div>

    <!-- Tech Stack Chips -->
    <div class="space-y-4">
      <h2 class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">// COMPLETE TECHNOLOGY STACK &amp; TAGS</h2>
      <div class="flex flex-wrap gap-2.5">
        <?php foreach ($stack as $tech): ?>
          <span class="px-4 py-2 rounded-full glass-card border border-white/15 font-mono text-xs tracking-wider uppercase text-white">
            <?= esc($tech) ?>
          </span>
        <?php endforeach; ?>
        <?php foreach ($tags as $t): ?>
          <span class="px-3.5 py-2 rounded-full bg-[var(--acid)]/15 border border-[var(--acid)]/40 font-mono text-xs tracking-wider uppercase text-[var(--acid)]">
            #<?= esc($t) ?>
          </span>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Media Gallery with Parallax & Lightbox Trigger -->
    <?php if (! empty($media)): ?>
      <div class="space-y-10 pt-8">
        <div class="flex items-center justify-between">
          <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase text-white">SCENE EXHIBITS</h2>
          <span class="font-mono text-xs tracking-[0.16em] uppercase text-[var(--text-dim)]">CLICK FRAME TO INSPECT IN LIGHTBOX</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <?php foreach ($media as $mIdx => $item): ?>
            <figure
              data-lightbox-trigger
              data-src="<?= base_url(ltrim((string) $item['path'], '/')) ?>"
              data-caption="<?= esc($item['caption']) ?>"
              data-cursor="view"
              class="<?= $mIdx === 0 ? 'md:col-span-2' : '' ?> group glass-card overflow-hidden cursor-pointer border border-white/15"
            >
              <div class="aspect-video overflow-hidden bg-[#07090F]">
                <img
                  src="<?= base_url(ltrim((string) $item['path'], '/')) ?>"
                  alt="<?= esc($item['caption']) ?>"
                  width="1600"
                  height="900"
                  loading="lazy"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                >
              </div>
              <figcaption class="px-6 py-4 flex items-center justify-between font-mono text-xs tracking-[0.14em] text-[var(--text-dim)] border-t border-white/10">
                <span><?= esc($item['caption']) ?></span>
                <span class="text-[var(--acid)]">EXHIBIT 0<?= $mIdx + 1 ?> ⤢</span>
              </figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <!-- Draggable Lightbox Modal -->
  <div
    id="case-lightbox"
    class="fixed inset-0 z-[135] bg-black/92 backdrop-blur-xl opacity-0 pointer-events-none transition-opacity duration-300 flex flex-col items-center justify-center p-6"
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
    aria-label="Media Lightbox"
  >
    <button
      type="button"
      id="case-lightbox-close"
      class="absolute top-6 right-8 px-4 py-2 rounded-full bg-white/10 hover:bg-[var(--acid)] hover:text-[var(--void)] font-mono text-xs tracking-[0.18em] uppercase text-white transition-colors"
    >
      CLOSE [ESC]
    </button>
    <div id="case-lightbox-drag" class="max-w-6xl w-full rounded-2xl overflow-hidden border border-white/20 shadow-2xl cursor-grab active:cursor-grabbing">
      <img id="case-lightbox-img" src="" alt="" class="w-full h-auto block">
    </div>
    <p id="case-lightbox-caption" class="mt-4 font-mono text-xs tracking-[0.18em] uppercase text-[var(--acid)]"></p>
  </div>

  <!-- Giant Next Project Footer Portal -->
  <?php if ($nextProject): ?>
    <div class="mt-28 border-t border-white/10 pt-20 px-6 sm:px-10 lg:px-16 max-w-[1700px] mx-auto">
      <a
        href="<?= base_url('work/' . $nextProject['slug']) ?>"
        data-cursor="view"
        class="group block glass-card p-10 sm:p-16 border border-white/15 hover:border-[var(--acid)] relative overflow-hidden"
      >
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-8">
          <div class="space-y-3">
            <span class="font-mono text-xs tracking-[0.24em] uppercase text-[var(--acid)]">// NEXT SCENE IN TIMELINE</span>
            <h2 class="font-display text-4xl sm:text-6xl lg:text-7xl font-black uppercase tracking-tight text-stroke group-hover:text-[var(--acid)]">
              <?= esc($nextProject['title']) ?>
            </h2>
            <p class="text-base sm:text-lg text-[var(--text-dim)] max-w-xl">
              <?= esc($nextProject['subtitle']) ?>
            </p>
          </div>
          <span class="inline-flex items-center gap-3 px-6 py-3.5 rounded-full bg-[var(--acid)] text-[var(--void)] font-mono text-xs font-bold tracking-[0.18em] uppercase shrink-0 group-hover:scale-105 transition-transform">
            <span>LOAD NEXT SCENE</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
          </span>
        </div>
      </a>
    </div>
  <?php endif; ?>

</article>

<?= $this->endSection() ?>
