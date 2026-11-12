<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('project_media')->truncate();
        $this->db->table('projects')->truncate();

        $now = date('Y-m-d H:i:s');

        $projects = [
            [
                'slug'        => 'shopping-france',
                'title'       => 'SHOPPING FRANCE',
                'subtitle'    => 'Full-stack e-commerce platform with cash-on-delivery & automated SMS/email transactional APIs',
                'year'        => 2025,
                'role'        => 'Lead Full-Stack Developer',
                'client'      => 'shoppingfrance.store',
                'summary'     => 'Custom CodeIgniter 4 & MySQL e-commerce platform built for high-conversion cash-on-delivery workflows, real-time order tracking, and automated SMS/email dispatch.',
                'challenge'   => 'Off-the-shelf e-commerce templates were bloated and lacked tailored cash-on-delivery verification, instant SMS confirmation, and streamlined mobile checkout required for social-commerce traffic.',
                'approach'    => 'Architected a custom MVC storefront and back-office in CodeIgniter 4 and MySQL, styled with Tailwind CSS, and integrated third-party REST APIs for transactional SMS and email notifications.',
                'solution'    => 'Launched shoppingfrance.store with sub-second mobile page loads, automated order status notifications, and targeted Facebook & Instagram acquisition funnels.',
                'results'     => json_encode([
                    'Live at shoppingfrance.store',
                    'Automated SMS & Email APIs',
                    'Sub-second mobile checkout',
                    'Full COD order pipeline',
                ]),
                'body'        => 'Shopping France combines a fast CodeIgniter 4 backend with frictionless mobile checkout and automated customer communication.',
                'cover_image' => '/assets/img/projects/shopping-france/cover.svg',
                'cover_video' => '',
                'accent'      => '#D4FF1F',
                'tags'        => json_encode(['web', 'mobile']),
                'stack'       => json_encode(['CodeIgniter 4', 'PHP 8.2', 'MySQL', 'Tailwind CSS', 'REST APIs', 'JavaScript']),
                'live_url'    => 'https://shoppingfrance.store',
                'repo_url'    => 'https://github.com/z3rokernel',
                'featured'    => 1,
                'sort_order'  => 1,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'deep-learning-elearning',
                'title'       => 'NEURAL E-LEARNING',
                'subtitle'    => 'Deep Learning platform for personalized course recommendations & AI exercise generation',
                'year'        => 2024,
                'role'        => 'AI Systems Researcher & Full-Stack Developer',
                'client'      => 'Master Thesis (UCBET // Level 7)',
                'summary'     => 'Intelligent adaptive learning platform combining deep learning recommendation models with generative AI for automated assessment creation.',
                'challenge'   => 'Static e-learning portals deliver identical content to every student regardless of mastery level and require instructors to manually author hundreds of practice exercises.',
                'approach'    => 'Designed a hybrid architecture pairing a relational SQL learning management backend with deep-learning recommendation pipelines and LLM-driven exercise synthesis.',
                'solution'    => 'Built an adaptive student dashboard that dynamically adjusts curriculum paths and generates real-time, graded practice problems tailored to each learner’s weak spots.',
                'results'     => json_encode([
                    'ENIC-NARIC Level 7 Master',
                    'Personalized AI curriculum',
                    'Automated exercise synthesis',
                    'REST API + SQL architecture',
                ]),
                'body'        => 'Developed as the capstone Master’s research project in Intelligent Computer Systems ("Towards a Deep Learning-Based E-learning Platform").',
                'cover_image' => '/assets/img/projects/deep-learning-elearning/cover.svg',
                'cover_video' => '',
                'accent'      => '#7B5CFF',
                'tags'        => json_encode(['ai', 'web']),
                'stack'       => json_encode(['PHP', 'Python', 'Deep Learning', 'MySQL', 'REST API', 'Tailwind CSS']),
                'live_url'    => 'https://mabdeira.dev/work/deep-learning-elearning',
                'repo_url'    => 'https://github.com/z3rokernel',
                'featured'    => 1,
                'sort_order'  => 2,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'm4b-enterprise-suite',
                'title'       => 'M4B ERP & CRM SUITE',
                'subtitle'    => 'Custom Laravel & PostgreSQL business management and invoicing platforms for SMBs',
                'year'        => 2025,
                'role'        => 'Full-Stack Web Developer',
                'client'      => 'M4B Designs Clients',
                'summary'     => 'Modular multi-tenant client portal, inventory tracker, and automated invoicing suite delivered across 30+ freelance engagements.',
                'challenge'   => 'Growing SMBs and associations relied on fragmented spreadsheets and manual invoicing that caused data entry errors and delayed customer follow-ups.',
                'approach'    => 'Built a reusable MVC core in Laravel and CodeIgniter 4 backed by PostgreSQL & MySQL, complete with role-based access control and PHPUnit test suites.',
                'solution'    => 'Delivered tailored web applications with automated PDF billing, real-time SQL analytics, SEO-optimized public portals, and Linux server deployment.',
                'results'     => json_encode([
                    '30+ client platforms shipped',
                    'PostgreSQL & MySQL schemas',
                    'PHPUnit & Postman verified',
                    '99.9% Linux server uptime',
                ]),
                'body'        => 'Battle-tested across 8+ years of freelance consulting with SMBs, e-commerce merchants, and non-profit organizations.',
                'cover_image' => '/assets/img/projects/m4b-enterprise-suite/cover.svg',
                'cover_video' => '',
                'accent'      => '#2DE2E6',
                'tags'        => json_encode(['web', 'open-source']),
                'stack'       => json_encode(['Laravel', 'CodeIgniter 4', 'PostgreSQL', 'MySQL', 'Tailwind CSS', 'PHPUnit']),
                'live_url'    => 'https://mabdeira.dev/work/m4b-enterprise-suite',
                'repo_url'    => 'https://github.com/z3rokernel',
                'featured'    => 1,
                'sort_order'  => 3,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'api-qa-sentinel',
                'title'       => 'API QA SENTINEL',
                'subtitle'    => 'Automated REST API contract testing, PHPUnit assertion runner & debugging toolkit',
                'year'        => 2026,
                'role'        => 'QA & Full-Stack Engineer',
                'client'      => 'Internal Engineering Tool',
                'summary'     => 'Quality assurance workbench for validating REST API endpoints, SQL query performance, and regression test suites prior to Linux production deployments.',
                'challenge'   => 'Third-party payment, SMS, and AI API integrations frequently introduce breaking schema changes or latency spikes that go unnoticed until production.',
                'approach'    => 'Combined Postman collection runners, automated PHPUnit feature tests, and custom PHP diagnostic scripts into a unified pre-release verification pipeline.',
                'solution'    => 'Catches regressions automatically on every commit, profiling SQL queries and verifying HTTP status codes, security headers, and rate limits.',
                'results'     => json_encode([
                    '100% endpoint coverage',
                    'Automated PHPUnit assertions',
                    'Postman contract validation',
                    'Zero-downtime releases',
                ]),
                'body'        => 'Built from hands-on QA and full-stack debugging experience to ensure every API integration ships with confidence.',
                'cover_image' => '/assets/img/projects/api-qa-sentinel/cover.svg',
                'cover_video' => '',
                'accent'      => '#D4FF1F',
                'tags'        => json_encode(['web', 'open-source', 'ai']),
                'stack'       => json_encode(['PHP 8.2', 'PHPUnit', 'Postman', 'REST API', 'MySQL', 'Linux']),
                'live_url'    => 'https://mabdeira.dev/work/api-qa-sentinel',
                'repo_url'    => 'https://github.com/z3rokernel',
                'featured'    => 1,
                'sort_order'  => 4,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'aether-engine',
                'title'       => 'MABDEIRA SHADER LAB',
                'subtitle'    => 'Interactive WebGL2 GLSL liquid shaders, GSAP 3 scroll choreography & 3D motion system',
                'year'        => 2026,
                'role'        => 'Creative Full-Stack Developer',
                'client'      => 'mabdeira.dev Flagship',
                'summary'     => 'The custom motion and WebGL shader engine powering mabdeira.dev—built with vanilla ES modules, Three.js, GSAP 3.13, Lenis, and Barba.js on CodeIgniter 4.',
                'challenge'   => 'Developer portfolios often sacrifice either visual impact or backend engineering quality and Core Web Vitals accessibility.',
                'approach'    => 'Paired a strict server-rendered CodeIgniter 4 MVC architecture and SQLite/MySQL data layer with progressive WebGL enhancement and reduced-motion fallbacks.',
                'solution'    => 'Delivers 60fps domain-warped FBM shaders, Matter.js rigid-body physics, and 5-slice Barba transitions while maintaining full keyboard and no-JS accessibility.',
                'results'     => json_encode([
                    '60 FPS WebGL2 shaders',
                    '95+ Accessibility score',
                    'CodeIgniter 4 SSR core',
                    'Full reduced-motion parity',
                ]),
                'body'        => 'A showcase of how modern PHP backend engineering and high-craft WebGL frontend motion can coexist in a single fast application.',
                'cover_image' => '/assets/img/projects/aether-engine/cover.svg',
                'cover_video' => '',
                'accent'      => '#FF3B5C',
                'tags'        => json_encode(['webgl', 'web', 'open-source']),
                'stack'       => json_encode(['CodeIgniter 4', 'Three.js', 'GLSL', 'GSAP 3', 'Tailwind CSS v4', 'Barba.js']),
                'live_url'    => 'https://mabdeira.dev',
                'repo_url'    => 'https://github.com/z3rokernel/nexus-folio',
                'featured'    => 1,
                'sort_order'  => 5,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'seo-cms-accelerator',
                'title'       => 'SEO & CMS ACCELERATOR',
                'subtitle'    => 'High-speed multilingual CMS & technical SEO optimization engine for SMB growth',
                'year'        => 2024,
                'role'        => 'Full-Stack Developer & SEO Consultant',
                'client'      => 'SMB & Association Clients',
                'summary'     => 'Custom content management and technical SEO toolkit featuring automated JSON-LD schema, dynamic sitemaps, and Core Web Vitals optimization.',
                'challenge'   => 'Client websites suffered from slow server response times, missing structured data, and poor organic search rankings.',
                'approach'    => 'Refactored legacy PHP backends into clean MVC architectures with query caching, semantic HTML5 landmarks, and automated OpenGraph/JSON-LD generation.',
                'solution'    => 'Boosted organic search visibility and cut page load times across dozens of client sites while giving editors an intuitive publishing workflow.',
                'results'     => json_encode([
                    '98+ Lighthouse SEO score',
                    '-60% average TTFB',
                    'Automated JSON-LD & Sitemaps',
                    'Multilingual FR / EN / AR',
                ]),
                'body'        => 'Engineered for measurable business growth—combining clean SQL indexing, server-side caching, and semantic web standards.',
                'cover_image' => '/assets/img/projects/seo-cms-accelerator/cover.svg',
                'cover_video' => '',
                'accent'      => '#2DE2E6',
                'tags'        => json_encode(['web', 'mobile']),
                'stack'       => json_encode(['PHP', 'Laravel', 'CodeIgniter 4', 'MySQL', 'Tailwind CSS', 'Technical SEO']),
                'live_url'    => 'https://mabdeira.dev/work/seo-cms-accelerator',
                'repo_url'    => 'https://github.com/z3rokernel',
                'featured'    => 1,
                'sort_order'  => 6,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('projects')->insertBatch($projects);

        $inserted = $this->db->table('projects')->get()->getResultArray();

        $mediaRows = [];
        foreach ($inserted as $proj) {
            $slug = $proj['slug'];
            $mediaRows[] = [
                'project_id' => $proj['id'],
                'type'       => 'image',
                'path'       => "/assets/img/projects/{$slug}/cover.svg",
                'caption'    => "{$proj['title']} — Primary Architecture & Production Interface",
                'sort_order' => 1,
            ];
            $mediaRows[] = [
                'project_id' => $proj['id'],
                'type'       => 'image',
                'path'       => "/assets/img/projects/{$slug}/detail-01.svg",
                'caption'    => "{$proj['title']} — Backend SQL Schema, REST API & System Dataflow",
                'sort_order' => 2,
            ];
            $mediaRows[] = [
                'project_id' => $proj['id'],
                'type'       => 'image',
                'path'       => "/assets/img/projects/{$slug}/detail-02.svg",
                'caption'    => "{$proj['title']} — Automated QA Testing, Postman & Performance Metrics",
                'sort_order' => 3,
            ];
        }

        if (! empty($mediaRows)) {
            $this->db->table('project_media')->insertBatch($mediaRows);
        }
    }
}
