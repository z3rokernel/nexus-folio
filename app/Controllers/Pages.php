<?php

namespace App\Controllers;

use App\Models\ExperienceModel;
use App\Models\ProjectModel;
use App\Models\SkillModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pages extends BaseController
{
    public function home(): string
    {
        $projectModel = new ProjectModel();
        $skillModel   = new SkillModel();

        $featuredProjects = $projectModel->getFeatured(6);
        $skills           = $skillModel->getAllOrdered();
        $groupedSkills    = $skillModel->getGroupedByCategory();

        $data = $this->withSiteContext([
            'namespace'        => 'home',
            'featuredProjects' => $featuredProjects,
            'skills'           => $skills,
            'groupedSkills'    => $groupedSkills,
            'stats'            => [
                ['value' => 6,    'suffix' => '+', 'label' => 'Years Engineering'],
                ['value' => 38,   'suffix' => '+', 'label' => 'Production Launches'],
                ['value' => 2840, 'suffix' => '+', 'label' => 'Verified Commits'],
                ['value' => 99,   'suffix' => '%', 'label' => 'A11y & Perf Target'],
            ],
            'capabilities'     => [
                [
                    'index'   => '01',
                    'title'   => 'Backend & Systems Architecture',
                    'tag'     => 'PHP 8.3 · CI4 · SQL/NoSQL',
                    'summary' => 'High-throughput server-rendered applications, clean domain models, strict security filters, and sub-50ms edge-cached APIs.',
                    'bullets' => ['CodeIgniter 4 & Modular MVC', 'SQLite / MySQL / Redis Pipelines', 'Zero-Trust Security & Rate Limiting'],
                    'icon'    => 'cpu',
                ],
                [
                    'index'   => '02',
                    'title'   => 'Creative Frontend & WebGL',
                    'tag'     => 'Three.js · GLSL · GSAP 3',
                    'summary' => 'Custom fragment shaders, 60fps scroll-scrubbed timelines, shared-element Flip transitions, and tactile magnetic micro-interactions.',
                    'bullets' => ['Domain-Warped FBM & Fluid Shaders', 'Lenis + ScrollTrigger Choreography', 'Barba.js Seamless Scene Transitions'],
                    'icon'    => 'sparkles',
                ],
                [
                    'index'   => '03',
                    'title'   => 'AI Products & Agentic Workflows',
                    'tag'     => 'LLMs · RAG · Streaming UI',
                    'summary' => 'Production AI interfaces that feel like precision instruments—streaming token visualizers, citation graphs, and low-latency orchestration.',
                    'bullets' => ['Multi-Agent RAG & Vector Search', 'Real-Time Generative Media UI', 'Deterministic Evaluation Suites'],
                    'icon'    => 'brain',
                ],
                [
                    'index'   => '04',
                    'title'   => 'Performance, A11y & DevOps',
                    'tag'     => 'Docker · CI/CD · WCAG AA',
                    'summary' => 'Progressive enhancement from the ground up: every experience works without JS, honors reduced-motion, and ships via automated CI.',
                    'bullets' => ['Lighthouse ≥ 90 Performance & A11y', 'Full Keyboard & Screen-Reader Parity', 'Docker Multi-Stage & GitHub Actions'],
                    'icon'    => 'shield-check',
                ],
            ],
            'processSteps'     => [
                [
                    'step'  => '01',
                    'name'  => 'DISCOVER & ARCHITECT',
                    'desc'  => 'Map system constraints, data schemas, latency budgets, and visual direction before writing a single line of code.',
                    'meta'  => 'SPEC // SYSTEM DESIGN',
                ],
                [
                    'step'  => '02',
                    'name'  => 'PROTOTYPE & SHADER LAB',
                    'desc'  => 'Craft custom GLSL shaders, kinetic typography timings, and interactive motion prototypes tuned for 60fps.',
                    'meta'  => 'MOTION // WEBGL PIPELINE',
                ],
                [
                    'step'  => '03',
                    'name'  => 'ENGINEER & INTEGRATE',
                    'desc'  => 'Build clean CodeIgniter 4 controllers, migrations, and vanilla ES modules with progressive enhancement and reduced-motion fallbacks.',
                    'meta'  => 'STACK // CI4 + ESM',
                ],
                [
                    'step'  => '04',
                    'name'  => 'VERIFY & SHIP',
                    'desc'  => 'Automated PHPUnit feature suites, CSP lockdown, Lighthouse audits, and zero-downtime containerized deployment.',
                    'meta'  => 'QA // PRODUCTION RELEASE',
                ],
            ],
            'meta' => [
                'title'       => 'NEXUS-FOLIO // Mostepha Amine BDEIR — Creative Technologist & Full-Stack Architect',
                'description' => 'Cinematic AI & WebGL portfolio of Mostepha Amine BDEIR — Full-Stack Developer, Creative Technologist, and AI Builder.',
                'canonical'   => base_url('/'),
                'og_type'     => 'website',
            ],
        ]);

        return view('pages/home', $data);
    }

    public function about(): string
    {
        $experienceModel = new ExperienceModel();
        $skillModel      = new SkillModel();
        $projectModel    = new ProjectModel();

        $data = $this->withSiteContext([
            'namespace'     => 'about',
            'experiences'   => $experienceModel->getTimeline(),
            'groupedSkills' => $skillModel->getGroupedByCategory(),
            'projects'      => $projectModel->getPublished(),
            'currently'     => [
                'building'   => 'Aether Engine v2 — Real-time WebGPU + GLSL node compositor',
                'learning'   => 'Rust audio DSP kernels & multi-modal agentic tool use',
                'listening'  => 'Lorn · Rival Consoles · Solar Fields (24-bit Studio Mix)',
                'reading'    => 'Real-Time Rendering (4th Ed.) & Designing Data-Intensive Applications',
            ],
            'meta' => [
                'title'       => 'ABOUT // Mostepha Amine BDEIR — NEXUS-FOLIO',
                'description' => 'Interactive terminal, engineering timeline, and architecture philosophy of Mostepha Amine BDEIR.',
                'canonical'   => base_url('about'),
                'og_type'     => 'profile',
            ],
        ]);

        return view('pages/about', $data);
    }

    public function notFound(): ResponseInterface
    {
        $data = $this->withSiteContext([
            'namespace' => 'not-found',
            'meta'      => [
                'title'       => '404 // SIGNAL LOST — NEXUS-FOLIO',
                'description' => 'Requested coordinate does not exist in the NEXUS-FOLIO sector.',
                'canonical'   => current_url(),
                'og_type'     => 'website',
            ],
        ]);

        return $this->response
            ->setStatusCode(404)
            ->setBody(view('pages/404', $data));
    }

    public function sitemap(): ResponseInterface
    {
        $projectModel = new ProjectModel();
        $projects     = $projectModel->getPublished();

        $urls = [
            ['loc' => base_url('/'),        'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => base_url('work'),     'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => base_url('about'),    'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => base_url('contact'),  'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        foreach ($projects as $p) {
            $urls[] = [
                'loc'        => base_url('work/' . $p['slug']),
                'priority'   => '0.85',
                'changefreq' => 'monthly',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . esc($u['loc']) . "</loc>\n";
            $xml .= '    <changefreq>' . esc($u['changefreq']) . "</changefreq>\n";
            $xml .= '    <priority>' . esc($u['priority']) . "</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return $this->response
            ->setStatusCode(200)
            ->setContentType('application/xml')
            ->setBody($xml);
    }
}
