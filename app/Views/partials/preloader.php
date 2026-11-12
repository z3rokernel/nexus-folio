<?php
/**
 * AI-render style Preloader ("Generating…")
 * @var array<string, mixed> $site
 */
?>
<div id="nexus-preloader" class="fixed inset-0 z-[140] pointer-events-none overflow-hidden flex items-center justify-center" aria-hidden="true">
  <!-- Split Curtain Panels -->
  <div id="preloader-panel-top" class="absolute inset-x-0 top-0 h-1/2 bg-[#05060A] border-b border-white/10"></div>
  <div id="preloader-panel-bottom" class="absolute inset-x-0 bottom-0 h-1/2 bg-[#05060A] border-t border-white/10"></div>

  <!-- Center Telemetry Stage -->
  <div id="preloader-stage" class="relative z-10 flex flex-col items-center gap-6 px-6 max-w-md w-full text-center">
    <!-- Pixel-Resolution Shader Canvas -->
    <div class="relative w-32 h-32 rounded-2xl overflow-hidden border border-[var(--acid)]/40 shadow-[0_0_50px_rgba(212,255,31,0.2)] bg-[#0B0D14]">
      <canvas id="preloader-canvas" width="128" height="128" class="w-full h-full block"></canvas>
      <div class="absolute inset-0 border border-white/10 rounded-2xl pointer-events-none"></div>
      <span class="absolute top-2 left-2.5 font-mono text-[10px] tracking-widest text-[var(--acid)]">LATENT//64</span>
      <span id="preloader-res-badge" class="absolute bottom-2 right-2.5 font-mono text-[10px] tracking-widest text-white/70">64x64</span>
    </div>

    <!-- Counter 0 -> 100 -->
    <div class="font-display text-5xl sm:text-6xl font-extrabold tracking-tight text-white tabular-nums">
      <span id="preloader-counter">000</span><span class="text-[var(--acid)] text-3xl">%</span>
    </div>

    <!-- Scramble Status Line -->
    <div class="w-full space-y-2">
      <div class="h-1 w-full bg-white/10 rounded-full overflow-hidden">
        <div id="preloader-bar" class="h-full bg-[var(--acid)] w-0 transition-none"></div>
      </div>
      <p id="preloader-status" class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">
        &gt; generating portfolio…
      </p>
      <p class="font-mono text-[10px] tracking-[0.18em] uppercase text-[var(--text-dim)]">
        SHADER PIPELINE · AUDIO SYNTH · SCENE TIMELINE
      </p>
    </div>
  </div>
</div>

