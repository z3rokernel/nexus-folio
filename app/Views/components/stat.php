<?php
/**
 * Component: Animated Counter Stat Card
 * @var int|string $value
 * @var string|null $suffix
 * @var string $label
 */
$value  = $value ?? 10;
$suffix = $suffix ?? '+';
$label  = $label ?? 'METRIC';
?>
<div class="glass-card p-6 sm:p-8 flex flex-col justify-between gap-3">
  <div class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight tabular-nums">
    <span data-counter="<?= esc((string) $value) ?>">0</span><span class="text-[var(--acid)]"><?= esc($suffix) ?></span>
  </div>
  <p class="font-mono text-xs tracking-[0.18em] uppercase text-[var(--text-dim)]">
    // <?= esc($label) ?>
  </p>
</div>

