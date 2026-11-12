<?php
/**
 * Component: Section Title
 * @var string $index
 * @var string $label
 * @var string $title
 * @var string|null $subtitle
 */
$index    = $index ?? '01';
$label    = $label ?? 'SYSTEM MODULE';
$title    = $title ?? 'SECTION TITLE';
$subtitle = $subtitle ?? null;
?>
<div class="space-y-4">
  <div class="inline-flex items-center gap-3 font-mono text-xs tracking-[0.22em] uppercase text-[var(--acid)]">
    <span><?= esc($index) ?> //</span>
    <span class="h-px w-8 bg-[var(--acid)]/50" aria-hidden="true"></span>
    <span class="text-white/75"><?= esc($label) ?></span>
  </div>
  <h2
    data-split="lines"
    aria-label="<?= esc($title) ?>"
    class="font-display section-display-size font-extrabold text-white tracking-tight uppercase"
  >
    <?= esc($title) ?>
  </h2>
  <?php if ($subtitle): ?>
    <p class="text-base sm:text-lg text-[var(--text-dim)] max-w-2xl leading-relaxed">
      <?= esc($subtitle) ?>
    </p>
  <?php endif; ?>
</div>

