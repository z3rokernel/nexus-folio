<?php
/**
 * @var array<string, mixed> $site
 * @var array<string, mixed> $meta
 * @var string $namespace
 * @var array<int, array<string, mixed>> $paletteProjects
 */
$pageTitle       = $meta['title'] ?? 'Mostepha Amine Bdeira // Full-Stack Web Developer (mabdeira.dev)';
$pageDescription = $meta['description'] ?? 'Full-Stack Web Developer (PHP, CodeIgniter 4, Laravel, SQL, REST APIs, QA) in Lyon, France.';
$pageCanonical   = $meta['canonical'] ?? current_url();
$pageOgType      = $meta['og_type'] ?? 'website';
$pageOgImage     = $meta['og_image'] ?? base_url('assets/img/projects/aether-engine/cover.svg');
$currentNamespace = $namespace ?? 'home';
?>
<!DOCTYPE html>
<html lang="en" class="dark" data-theme="acid">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle) ?></title>
  <meta name="description" content="<?= esc($pageDescription) ?>">
  <link rel="canonical" href="<?= esc($pageCanonical) ?>">
  <meta name="theme-color" content="#05060A">

  <!-- OpenGraph / Social -->
  <meta property="og:type" content="<?= esc($pageOgType) ?>">
  <meta property="og:title" content="<?= esc($pageTitle) ?>">
  <meta property="og:description" content="<?= esc($pageDescription) ?>">
  <meta property="og:url" content="<?= esc($pageCanonical) ?>">
  <meta property="og:image" content="<?= esc($pageOgImage) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= esc($pageTitle) ?>">
  <meta name="twitter:description" content="<?= esc($pageDescription) ?>">
  <meta name="twitter:image" content="<?= esc($pageOgImage) ?>">

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  <?= json_encode([
      '@context'    => 'https://schema.org',
      '@type'       => $currentNamespace === 'project' ? 'CreativeWork' : 'Person',
      'name'        => $site['name'] ?? 'Mostepha Amine Bdeira',
      'url'         => 'https://mabdeira.dev',
      'email'       => $site['email'] ?? 'contact@mabdeira.dev',
      'telephone'   => $site['phone'] ?? '+33 6 15 21 88 14',
      'jobTitle'    => 'Full-Stack Web Developer & QA Specialist',
      'address'     => [
          '@type'           => 'PostalAddress',
          'addressLocality' => $site['city'] ?? 'Lyon, France',
      ],
      'sameAs'      => [
          'https://github.com/z3rokernel',
          'https://linkedin.com/in/m4b007',
      ],
      'description' => $pageDescription,
  ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
  </script>

  <!-- Google Fonts: Unbounded, Inter Tight, JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,400;0,500;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500;600;700&family=Unbounded:wght@600;700;800;900&display=swap" rel="stylesheet">

  <!-- Compiled Tailwind CSS v4 + Design Tokens -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">

  <!-- Three.js Importmap (ES Module) -->
  <script type="importmap">
  {
    "imports": {
      "three": "https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js",
      "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.170.0/examples/jsm/"
    }
  }
  </script>

  <!-- Early Theme & Reduced-Motion Hydration (prevents flash) -->
  <script>
    (function() {
      try {
        var savedTheme = localStorage.getItem('nexus_theme');
        if (savedTheme && ['acid', 'plasma', 'cyan'].indexOf(savedTheme) !== -1) {
          document.documentElement.setAttribute('data-theme', savedTheme);
        }
        var rm = localStorage.getItem('nexus_reduced_motion');
        if (rm === '1' || (rm === null && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
          document.documentElement.classList.add('reduced-motion');
        }
      } catch (e) {}
    })();
  </script>
</head>
<body data-barba="wrapper" class="bg-[var(--void)] text-[var(--text)] antialiased selection:bg-[var(--acid)] selection:text-[var(--void)]">

  <!-- Skip to Main Content Link (Keyboard Accessibility) -->
  <a href="#main-content" class="skip-link">Skip to main scene</a>

  <!-- Polite Live Region for Route & State Announcements -->
  <div id="a11y-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

  <!-- AI "Generating…" Preloader -->
  <?= view('partials/preloader', ['site' => $site]) ?>

  <!-- Persistent WebGL Background Canvas -->
  <canvas id="gl-bg" aria-hidden="true"></canvas>

  <!-- Animated Film Grain Canvas Overlay -->
  <canvas id="film-grain" aria-hidden="true"></canvas>

  <!-- Custom Dual-Layer Cursor (Desktop Only) -->
  <div id="nexus-cursor-dot" aria-hidden="true"></div>
  <div id="nexus-cursor-ring" aria-hidden="true">
    <span id="nexus-cursor-label">VIEW</span>
  </div>

  <!-- Barba 5-Slice Transition Stage -->
  <div id="transition-stage" aria-hidden="true">
    <div class="transition-slice"></div>
    <div class="transition-slice"></div>
    <div class="transition-slice"></div>
    <div class="transition-slice"></div>
    <div class="transition-slice"></div>
    <div id="transition-label" class="fixed inset-0 flex items-center justify-center opacity-0 pointer-events-none z-20">
      <div class="px-6 py-3 rounded-full bg-[var(--ink)]/90 border border-[var(--acid)]/40 font-mono text-xs tracking-[0.25em] uppercase text-[var(--acid)] shadow-[0_0_40px_var(--acid-glow)]">
        <span id="transition-label-text">// LOADING SCENE: HOME</span>
      </div>
    </div>
  </div>

  <!-- Global HUD Frame & Top Navigation -->
  <?= view('partials/hud', ['site' => $site, 'namespace' => $currentNamespace]) ?>

  <!-- Full-Screen Staggered Menu Overlay -->
  <?= view('partials/menu-overlay', ['site' => $site, 'namespace' => $currentNamespace, 'paletteProjects' => $paletteProjects ?? []]) ?>

  <!-- Command Palette (Ctrl/⌘ + K) -->
  <?= view('partials/command-palette', ['site' => $site, 'paletteProjects' => $paletteProjects ?? []]) ?>

  <!-- Idle Prompt Toast (> still there?) -->
  <div id="idle-toast" class="fixed bottom-14 left-1/2 -translate-x-1/2 z-50 px-5 py-2.5 rounded-full glass-card border border-[var(--acid)]/40 font-mono text-xs tracking-[0.2em] text-[var(--acid)] opacity-0 pointer-events-none transition-opacity duration-500" aria-hidden="true">
    <span>&gt; SYSTEM IDLE // STILL THERE? MOVE CURSOR TO RESUME</span>
  </div>

  <!-- Global Notification Toast (Copy Email / Konami / Theme) -->
  <div id="nexus-toast" class="fixed top-20 right-6 z-[130] px-5 py-3 rounded-xl glass-card border border-[var(--acid)]/50 font-mono text-xs tracking-[0.15em] text-[var(--text)] opacity-0 translate-y-[-10px] pointer-events-none transition-all duration-300" role="status" aria-live="polite">
    <span id="nexus-toast-text">// SYSTEM READY</span>
  </div>

  <!-- Barba Dynamic Page Container -->
  <main
    id="main-content"
    data-barba="container"
    data-barba-namespace="<?= esc($currentNamespace) ?>"
    class="relative z-10 min-h-screen flex flex-col justify-between"
    tabindex="-1"
  >
    <div class="flex-1">
      <?= $this->renderSection('content') ?>
    </div>

    <!-- Global Footer inside Barba Container so per-page ScrollTriggers attach cleanly -->
    <?= view('partials/footer', ['site' => $site]) ?>
  </main>

  <!-- Pinned CDN Libraries (from docs/03-ANIMATION-SPEC.md) -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrambleTextPlugin.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Flip.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/CustomEase.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/Draggable.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/InertiaPlugin.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/lenis@1.3.4/dist/lenis.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3/dist/barba.umd.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/matter-js@0.20.0/build/matter.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/howler@2.2.4/dist/howler.min.js" defer></script>
  <script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js" defer></script>

  <!-- Application Entry Point (Vanilla ES Module) -->
  <script type="module" src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>

