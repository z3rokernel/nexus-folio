<?php
/**
 * Component: Skill Chip
 * @var string $name
 * @var string $category
 * @var int|string|null $level
 */
$name     = $name ?? 'Skill';
$category = $category ?? 'General';
$level    = $level ?? 90;
?>
<span
  data-skill-chip
  data-category="<?= esc($category) ?>"
  class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card border border-white/15 hover:border-[var(--acid)] font-mono text-xs tracking-[0.12em] uppercase text-white select-none transition-colors"
>
  <span class="w-1.5 h-1.5 rounded-full bg-[var(--acid)]"></span>
  <span><?= esc($name) ?></span>
  <span class="text-[10px] text-[var(--text-dim)]"><?= esc((string) $level) ?>%</span>
</span>
