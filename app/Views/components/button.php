<?php
/**
 * Component: Magnetic Liquid-Fill Button
 * @var string $label
 * @var string $href
 * @var bool|null $primary
 * @var string|null $icon
 * @var string|null $cursor
 */
$label   = $label ?? 'EXPLORE';
$href    = $href ?? '#';
$primary = $primary ?? false;
$icon    = $icon ?? 'arrow-up-right';
$cursor  = $cursor ?? 'link';
?>
<a
  href="<?= esc($href) ?>"
  data-magnetic
  data-cursor="<?= esc($cursor) ?>"
  class="btn-nexus <?= $primary ? 'btn-nexus-primary' : '' ?>"
>
  <span class="btn-fill" aria-hidden="true"></span>
  <span><?= esc($label) ?></span>
  <?php if ($icon): ?>
    <i data-lucide="<?= esc($icon) ?>" class="w-4 h-4"></i>
  <?php endif; ?>
</a>

