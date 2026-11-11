<?php
/**
 * Component: Project Card (Tilt + WebGL Displacement Target)
 * @var array<string, mixed> $project
 * @var int|string|null $index
 */
$idx   = isset($index) ? str_pad((string) $index, 2, '0', STR_PAD_LEFT) : '01';
$tags  = $project['tags'] ?? [];
$stack = array_slice($project['stack'] ?? [], 0, 4);
?>
<article
  data-project-card
  data-slug="<?= esc($project['slug']) ?>"
  data-tags="<?= esc(implode(',', $tags)) ?>"
  data-tilt
  data-cursor="view"
  class="group tilt-card glass-card flex flex-col justify-between overflow-hidden transition-all duration-500"
>
  <div class="tilt-glare" aria-hidden="true"></div>

  <!-- Top Telemetry Header -->
  <div class="flex items-center justify-between px-6 py-4 border-b border-white/10 font-mono text-xs tracking-[0.16em] uppercase">
    <span class="text-[var(--acid)]">SCENE <?= esc($idx) ?></span>
    <div class="flex items-center gap-2 text-[var(--text-dim)]">
      <span><?= esc((string) ($project['year'] ?? '2026')) ?></span>
      <span>//</span>
      <span><?= esc($project['client'] ?? 'STUDIO') ?></span>
    </div>
  </div>

  <!-- Media Stage with WebGL Hover Displacement Hook -->
  <a
    href="<?= base_url('work/' . $project['slug']) ?>"
    data-flip-id="project-media-<?= esc($project['slug']) ?>"
    class="relative block aspect-video overflow-hidden bg-[#080A10]"
  >
    <img
      src="<?= base_url(ltrim((string) $project['cover_image'], '/')) ?>"
      alt="<?= esc($project['title']) ?> — <?= esc($project['subtitle']) ?>"
      width="1280"
      height="720"
      loading="lazy"
      data-distort-img
      class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-[#05060A] via-transparent to-transparent opacity-80"></div>

    <!-- Tag Badges -->
    <div class="absolute top-4 left-4 flex flex-wrap gap-1.5">
      <?php foreach ($tags as $tag): ?>
        <span class="px-2.5 py-1 rounded-full bg-black/75 backdrop-blur-md border border-white/15 font-mono text-[10px] tracking-[0.15em] uppercase text-[var(--acid)]">
          <?= esc($tag) ?>
        </span>
      <?php endforeach; ?>
    </div>
  </a>

  <!-- Card Body -->
  <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between gap-6">
    <div class="space-y-2.5">
      <h3 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight uppercase">
        <a href="<?= base_url('work/' . $project['slug']) ?>" class="text-white group-hover:text-[var(--acid)] transition-colors">
          <?= esc($project['title']) ?>
        </a>
      </h3>
      <p class="text-sm sm:text-base text-[var(--text-dim)] line-clamp-2">
        <?= esc($project['subtitle']) ?>
      </p>
    </div>

    <div class="pt-4 border-t border-white/10 flex items-center justify-between gap-4">
      <div class="flex flex-wrap gap-1.5">
        <?php foreach ($stack as $tech): ?>
          <span class="px-2.5 py-0.5 rounded bg-white/5 font-mono text-[10px] tracking-wider text-white/75">
            <?= esc($tech) ?>
          </span>
        <?php endforeach; ?>
      </div>
      <a
        href="<?= base_url('work/' . $project['slug']) ?>"
        class="inline-flex items-center gap-1.5 font-mono text-xs tracking-[0.16em] uppercase text-[var(--acid)] group-hover:translate-x-1 transition-transform shrink-0"
        aria-label="Inspect <?= esc($project['title']) ?> case study"
      >
        <span>INSPECT</span>
        <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
      </a>
    </div>
  </div>
</article>
