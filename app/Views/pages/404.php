<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section data-scene="01" data-scene-label="ERR_404 // SIGNAL LOST" class="min-h-[82svh] flex items-center justify-center py-28 px-6 text-center">
  <div class="max-w-2xl mx-auto space-y-8 glass-card p-10 sm:p-16 border border-[var(--danger)]/40">
    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-[var(--danger)]/15 border border-[var(--danger)]/40 font-mono text-xs tracking-[0.22em] uppercase text-[var(--danger)]">
      <span class="w-2 h-2 rounded-full bg-[var(--danger)] animate-ping"></span>
      <span>ERR_CODE // 404 NOT FOUND</span>
    </div>

    <h1
      class="font-display text-7xl sm:text-9xl font-black tracking-tighter uppercase text-white"
      style="text-shadow: -4px 0 #FF3B5C, 4px 0 #2DE2E6;"
    >
      404
    </h1>

    <p class="font-mono text-base sm:text-lg tracking-[0.22em] uppercase text-[var(--acid)]">
      // SIGNAL LOST IN VOID SECTOR
    </p>

    <p class="text-base text-[var(--text-dim)] max-w-md mx-auto">
      The coordinate you requested has been decommissioned or moved to another timeline.
    </p>

    <div class="pt-4 flex justify-center">
      <?= view('components/button', [
          'label'   => 'RETURN TO BASE',
          'href'    => base_url('/'),
          'primary' => true,
          'icon'    => 'compass',
          'cursor'  => 'link',
      ]) ?>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

