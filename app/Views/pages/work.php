<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Work Archive (/work) — GSAP Flip Filters & Grid/List Toggle
 * @var array<string, mixed> $site
 * @var array<int, array<string, mixed>> $projects
 * @var string $activeTag
 * @var array<int, string> $tags
 */
$tagLabels = [
    'all'         => 'ALL SCENES',
    'ai'          => 'AI SYSTEMS',
    'webgl'       => 'WEBGL & SHADERS',
    'web'         => 'FULL-STACK WEB',
    'mobile'      => 'MOBILE & PERF',
    'open-source' => 'OPEN SOURCE',
];
?>

<section data-scene="01" data-scene-label="WORK ARCHIVE" class="pt-32 pb-28 px-6 sm:px-10 lg:px-16">
  <div class="max-w-[1750px] mx-auto space-y-14">

    <!-- Page Header -->
    <div class="space-y-6 border-b border-white/10 pb-10">
      <div class="inline-flex items-center gap-3 font-mono text-xs tracking-[0.22em] uppercase text-[var(--acid)]">
        <span>ARCHIVE // 01</span>
        <span class="h-px w-8 bg-[var(--acid)]/50"></span>
        <span class="text-white/75">PRODUCTION INDEX (<?= count($projects) ?>)</span>
      </div>

      <h1
        data-split="chars"
        aria-label="SELECTED WORK ARCHIVE"
        class="font-display hero-display-size font-black uppercase tracking-tight text-white"
      >
        SELECTED <span class="text-chrome">WORK.</span>
      </h1>

      <p class="text-lg sm:text-xl text-[var(--text-dim)] max-w-2xl">
        Every project is engineered as a standalone scene—combining resilient backend architecture with tactile motion and verified performance.
      </p>
    </div>

    <!-- Filter Chips (GSAP Flip + Progressive Enhancement Links) & Grid/List View Toggle -->
    <div class="flex flex-wrap items-center justify-between gap-6">
      <div class="flex flex-wrap items-center gap-2.5" role="toolbar" aria-label="Filter projects by category">
        <?php foreach ($tags as $tag):
            $isActive = ($activeTag === $tag);
            $href     = $tag === 'all' ? base_url('work') : base_url('work?tag=' . urlencode($tag));
        ?>
          <a
            href="<?= esc($href) ?>"
            data-filter-btn="<?= esc($tag) ?>"
            data-magnetic
            data-cursor="link"
            aria-pressed="<?= $isActive ? 'true' : 'false' ?>"
            class="px-4 py-2 rounded-full font-mono text-xs tracking-[0.16em] uppercase border transition-all <?= $isActive ? 'bg-[var(--acid)] text-[var(--void)] border-[var(--acid)] font-bold shadow-[0_0_20px_var(--acid-glow)]' : 'bg-white/5 text-white/80 border-white/15 hover:border-[var(--acid)]' ?>"
          >
            <?= esc($tagLabels[$tag] ?? strtoupper($tag)) ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Grid <-> List Toggle -->
      <div class="inline-flex items-center gap-1 p-1 rounded-full bg-[#0B0D14] border border-white/15 font-mono text-xs tracking-[0.14em] uppercase">
        <button
          type="button"
          data-view-mode="grid"
          aria-pressed="true"
          class="px-3.5 py-1.5 rounded-full bg-[var(--acid)] text-[var(--void)] font-bold transition-colors inline-flex items-center gap-1.5"
        >
          <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
          <span>GRID</span>
        </button>
        <button
          type="button"
          data-view-mode="list"
          aria-pressed="false"
          class="px-3.5 py-1.5 rounded-full text-white/75 hover:text-white transition-colors inline-flex items-center gap-1.5"
        >
          <i data-lucide="list" class="w-3.5 h-3.5"></i>
          <span>LIST</span>
        </button>
      </div>
    </div>

    <!-- Grid View Container (Animated with GSAP Flip) -->
    <div id="work-grid-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
      <?php foreach ($projects as $idx => $proj): ?>
        <?= view('components/project-card', ['project' => $proj, 'index' => $idx + 1]) ?>
      <?php endforeach; ?>
    </div>

    <!-- List View Container (Hidden by default; toggled via JS with floating cursor media preview) -->
    <div id="work-list-container" class="hidden divide-y divide-white/10 border-y border-white/10">
      <?php foreach ($projects as $idx => $proj):
          $sceneNum = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
          $tagsStr  = implode(',', $proj['tags'] ?? []);
      ?>
        <a
          href="<?= base_url('work/' . $proj['slug']) ?>"
          data-list-row
          data-tags="<?= esc($tagsStr) ?>"
          data-preview="<?= base_url(ltrim((string) $proj['cover_image'], '/')) ?>"
          data-cursor="view"
          class="group py-7 px-4 flex flex-wrap items-center justify-between gap-6 hover:bg-white/[0.03] transition-colors"
        >
          <div class="flex items-baseline gap-6">
            <span class="font-mono text-xs text-[var(--acid)] tracking-[0.2em]"><?= esc($sceneNum) ?> //</span>
            <h2 class="font-display text-2xl sm:text-4xl font-extrabold uppercase text-white group-hover:text-[var(--acid)] transition-colors">
              <?= esc($proj['title']) ?>
            </h2>
          </div>

          <div class="flex items-center gap-8 font-mono text-xs tracking-[0.16em] uppercase text-[var(--text-dim)]">
            <span class="hidden lg:inline"><?= esc($proj['client']) ?></span>
            <span class="hidden sm:inline text-white/80"><?= esc($proj['role']) ?></span>
            <span class="text-[var(--acid)]"><?= esc((string) $proj['year']) ?></span>
            <i data-lucide="arrow-up-right" class="w-5 h-5 text-[var(--acid)] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Floating Cursor Preview Image for List Mode -->
    <div
      id="work-list-floating-preview"
      class="fixed top-0 left-0 w-80 aspect-video rounded-2xl overflow-hidden border border-[var(--acid)]/50 shadow-2xl pointer-events-none z-50 opacity-0 scale-90 transition-opacity duration-200 hidden lg:block"
      aria-hidden="true"
    >
      <img id="work-list-floating-img" src="<?= base_url('assets/img/projects/aether-engine/cover.svg') ?>" alt="" class="w-full h-full object-cover">
    </div>

  </div>
</section>

<?= $this->endSection() ?>

