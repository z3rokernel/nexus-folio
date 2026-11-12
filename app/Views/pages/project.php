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
$slug        = (string) ($project['slug'] ?? '');

// Project-specific Engineering & QA Blueprint data
$blueprints = [
    'shopping-france' => [
        'pipeline' => [
            ['step' => '01', 'title' => 'Social Ad Traffic', 'desc' => 'Facebook & Instagram ad campaigns land on mobile-first Tailwind CSS product pages (< 1.2s load).', 'badge' => 'ACQUISITION'],
            ['step' => '02', 'title' => '1-Page COD Checkout', 'desc' => 'Frictionless Cash-on-Delivery order form with strict French phone format & CSRF validation.', 'badge' => 'CONVERSION'],
            ['step' => '03', 'title' => 'CodeIgniter 4 & MySQL', 'desc' => 'Atomic SQL transaction records order, customer, and decrements live product inventory.', 'badge' => 'PERSISTENCE'],
            ['step' => '04', 'title' => 'SMS & Email REST APIs', 'desc' => 'Instant SMS confirmation + transactional HTML email dispatched via third-party REST webhooks.', 'badge' => 'NOTIFICATION'],
        ],
        'backend' => [
            'schema'    => 'MySQL 8 Normalized Schema: `products`, `product_variants`, `orders` (COD state machine), `order_items`, `api_sms_logs`.',
            'endpoints' => 'POST `/checkout/cod-order` (Order Creation + Stock Lock) · POST `/api/webhooks/sms-status` (Delivery Callback) · GET `/admin/orders/export`.',
            'security'  => 'CodeIgniter 4 CSRF protection, honeypot anti-bot fields, strict server-side phone/postal validation, and duplicate order throttling.',
        ],
        'qa' => [
            'postman'   => '28 Postman API assertions covering valid COD orders (HTTP 201), invalid phone rejection (HTTP 422), and SMS gateway webhook callbacks.',
            'phpunit'   => 'Automated feature tests verifying MySQL stock decrements, order total calculations, and fallback handling when external APIs timeout.',
            'debugging' => 'Custom server log parser tracking SMS delivery rates (99.4%) and identifying failed webhook retries in production.',
        ],
    ],
    'deep-learning-elearning' => [
        'pipeline' => [
            ['step' => '01', 'title' => 'Learner Telemetry', 'desc' => 'Captures quiz scores, time-on-module, and error patterns across computer science courses.', 'badge' => 'DATA INPUT'],
            ['step' => '02', 'title' => 'Neural Recommendation', 'desc' => 'Deep learning collaborative filtering ranks the next optimal learning modules per student.', 'badge' => 'DEEP LEARNING'],
            ['step' => '03', 'title' => 'AI Exercise Synthesis', 'desc' => 'Generates personalized practice exercises & difficulty-adjusted quizzes automatically.', 'badge' => 'GENERATIVE AI'],
            ['step' => '04', 'title' => 'Instructor Analytics', 'desc' => 'Web dashboard displays mastery heatmaps and cohort progression metrics.', 'badge' => 'EVALUATION'],
        ],
        'backend' => [
            'schema'    => 'Relational schema storing `learners`, `course_modules`, `knowledge_states`, `generated_exercises`, and `recommendation_logs`.',
            'endpoints' => 'GET `/api/recommendations/{learnerId}` · POST `/api/exercises/generate` · POST `/api/telemetry/attempt`.',
            'security'  => 'Role-based access control separating Student, Instructor, and Research Admin views with anonymized dataset exports.',
        ],
        'qa' => [
            'postman'   => 'REST API contract tests validating inference response payloads, latency thresholds, and fallback course rankings.',
            'phpunit'   => 'Unit & integration tests verifying scoring algorithms, progression unlocks, and database integrity.',
            'debugging' => 'Model evaluation pipeline measuring recommendation precision/recall and exercise difficulty calibration (Master Level 7 Thesis).',
        ],
    ],
];

$bp = $blueprints[$slug] ?? [
    'pipeline' => [
        ['step' => '01', 'title' => 'Requirements & Specs', 'desc' => 'Business requirements analysis, database modeling, and REST API contract definition.', 'badge' => 'SPECIFICATION'],
        ['step' => '02', 'title' => 'MVC Backend & SQL', 'desc' => 'Clean PHP (CodeIgniter 4 / Laravel) controllers paired with indexed MySQL/PostgreSQL tables.', 'badge' => 'ENGINEERING'],
        ['step' => '03', 'title' => 'QA & API Verification', 'desc' => 'Comprehensive Postman collection testing, PHPUnit assertions, and edge-case validation.', 'badge' => 'QUALITY ASSURANCE'],
        ['step' => '04', 'title' => 'Linux Deployment', 'desc' => 'Production release with SSL, security headers, automated backups, and performance monitoring.', 'badge' => 'PRODUCTION'],
    ],
    'backend' => [
        'schema'    => 'Normalized relational database design (MySQL / PostgreSQL) with foreign-key integrity, composite indexes, and migration version control.',
        'endpoints' => 'RESTful JSON & SSR endpoints built with strict input validation, structured error responses (400/422/429), and caching.',
        'security'  => 'CSRF token verification, SQL injection prevention via prepared statements, XSS output escaping (`esc()`), and rate limiting.',
    ],
    'qa' => [
        'postman'   => 'End-to-end Postman test suites verifying authentication, CRUD operations, pagination, and malformed payload handling.',
        'phpunit'   => 'Automated PHPUnit feature and model tests ensuring zero regressions across database transactions and business logic.',
        'debugging' => 'Proactive log inspection, SQL query profiling (`EXPLAIN`), and structured bug triage reports.',
    ],
];
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

    <!-- Interactive 3-Tab Engineering & QA Blueprint -->
    <div class="glass-card p-6 sm:p-10 border border-[var(--acid)]/30 space-y-8" data-blueprint-tabs>
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/10 pb-6">
        <div>
          <span class="font-mono text-xs tracking-[0.2em] uppercase text-[var(--acid)]">// INTERACTIVE TECHNICAL DEEP-DIVE</span>
          <h2 class="font-display text-2xl sm:text-3xl font-extrabold uppercase text-white mt-1">ENGINEERING &amp; QA BLUEPRINT</h2>
        </div>

        <div class="flex flex-wrap gap-2" role="tablist" aria-label="Technical Blueprint Tabs">
          <button
            type="button"
            role="tab"
            aria-selected="true"
            data-bp-tab="pipeline"
            class="px-4 py-2 rounded-full font-mono text-xs tracking-wider uppercase transition-colors bg-[var(--acid)] text-[var(--void)] font-bold"
          >
            01 // SYSTEM PIPELINE
          </button>
          <button
            type="button"
            role="tab"
            aria-selected="false"
            data-bp-tab="backend"
            class="px-4 py-2 rounded-full font-mono text-xs tracking-wider uppercase transition-colors bg-white/5 text-white/80 border border-white/15 hover:border-[var(--acid)]"
          >
            02 // SQL &amp; API ARCHITECTURE
          </button>
          <button
            type="button"
            role="tab"
            aria-selected="false"
            data-bp-tab="qa"
            class="px-4 py-2 rounded-full font-mono text-xs tracking-wider uppercase transition-colors bg-white/5 text-white/80 border border-white/15 hover:border-[var(--acid)]"
          >
            03 // QA &amp; TESTING SUITE
          </button>
        </div>
      </div>

      <!-- Tab Panel 1: Visual System Pipeline -->
      <div data-bp-panel="pipeline" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($bp['pipeline'] as $node): ?>
          <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 hover:border-[var(--acid)]/60 transition-colors space-y-3 relative">
            <div class="flex items-center justify-between font-mono text-[11px]">
              <span class="text-[var(--acid)] font-bold">STAGE <?= esc($node['step']) ?></span>
              <span class="px-2 py-0.5 rounded bg-white/5 text-[var(--cyan)] text-[10px]"><?= esc($node['badge']) ?></span>
            </div>
            <h3 class="font-display text-lg font-bold uppercase text-white"><?= esc($node['title']) ?></h3>
            <p class="text-sm text-[var(--text-dim)] leading-relaxed"><?= esc($node['desc']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Tab Panel 2: Backend, SQL & API Spec -->
      <div data-bp-panel="backend" class="hidden grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 space-y-2">
          <span class="font-mono text-xs uppercase tracking-wider text-[var(--acid)]">01 // DATABASE SCHEMA (SQL)</span>
          <p class="text-sm sm:text-base text-white/90 leading-relaxed"><?= esc($bp['backend']['schema']) ?></p>
        </div>
        <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 space-y-2">
          <span class="font-mono text-xs uppercase tracking-wider text-[var(--cyan)]">02 // REST API &amp; ROUTES</span>
          <p class="text-sm sm:text-base text-white/90 leading-relaxed"><?= esc($bp['backend']['endpoints']) ?></p>
        </div>
        <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 space-y-2">
          <span class="font-mono text-xs uppercase tracking-wider text-[var(--plasma)]">03 // SECURITY &amp; VALIDATION</span>
          <p class="text-sm sm:text-base text-white/90 leading-relaxed"><?= esc($bp['backend']['security']) ?></p>
        </div>
      </div>

      <!-- Tab Panel 3: QA Test Plan & Verification -->
      <div data-bp-panel="qa" class="hidden grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 space-y-2">
          <span class="font-mono text-xs uppercase tracking-wider text-[var(--acid)]">01 // POSTMAN API TESTING</span>
          <p class="text-sm sm:text-base text-white/90 leading-relaxed"><?= esc($bp['qa']['postman']) ?></p>
        </div>
        <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 space-y-2">
          <span class="font-mono text-xs uppercase tracking-wider text-[var(--cyan)]">02 // PHPUNIT AUTOMATION</span>
          <p class="text-sm sm:text-base text-white/90 leading-relaxed"><?= esc($bp['qa']['phpunit']) ?></p>
        </div>
        <div class="p-6 rounded-2xl bg-[#07090F]/90 border border-white/10 space-y-2">
          <span class="font-mono text-xs uppercase tracking-wider text-[var(--plasma)]">03 // DEBUGGING &amp; LOGS</span>
          <p class="text-sm sm:text-base text-white/90 leading-relaxed"><?= esc($bp['qa']['debugging']) ?></p>
        </div>
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

