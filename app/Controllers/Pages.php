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
                ['value' => 8,   'suffix' => '+', 'label' => 'Years Freelance Experience'],
                ['value' => 30,  'suffix' => '+', 'label' => 'Custom Projects Delivered'],
                ['value' => 100, 'suffix' => '%', 'label' => 'API & PHPUnit QA Focus'],
                ['value' => 3,   'suffix' => '',  'label' => 'Languages (FR · EN · AR)'],
            ],
            'capabilities'     => [
                [
                    'index'   => '01',
                    'title'   => 'Full-Stack PHP & MVC Architecture',
                    'tag'     => 'PHP 8.2+ · CodeIgniter 4 · Laravel',
                    'summary' => '8+ years developing bespoke web applications, e-commerce platforms, and custom business portals for SMBs and organizations.',
                    'bullets' => ['CodeIgniter 4 & Laravel MVC', 'REST API Design & Third-Party Sync', 'Clean, Maintainable Server-Rendered Code'],
                    'icon'    => 'cpu',
                ],
                [
                    'index'   => '02',
                    'title'   => 'Relational Databases & SQL',
                    'tag'     => 'MySQL · PostgreSQL · SQL Optimization',
                    'summary' => 'Designing normalized relational schemas, complex analytical queries, and high-integrity transactional data layers tailored to each client.',
                    'bullets' => ['MySQL & PostgreSQL Architecture', 'Migrations, Seeders & Indexing', 'Data Integrity & Query Profiling'],
                    'icon'    => 'database',
                ],
                [
                    'index'   => '03',
                    'title'   => 'QA Testing, API Verification & Debugging',
                    'tag'     => 'Postman · PHPUnit · Linux Deployment',
                    'summary' => 'Rigorous quality assurance across the full stack: automated PHPUnit test suites, Postman REST API contract testing, and root-cause debugging.',
                    'bullets' => ['Postman REST API Test Suites', 'PHPUnit Unit & Feature Assertions', 'Custom Debugging Scripts & Linux Ops'],
                    'icon'    => 'shield-check',
                ],
                [
                    'index'   => '04',
                    'title'   => 'Responsive Frontend, Motion & AI',
                    'tag'     => 'Tailwind CSS · JS · AI APIs · SEO',
                    'summary' => 'Crafting responsive, accessible interfaces with Tailwind CSS, interactive WebGL/GSAP motion, technical SEO, and AI API integrations.',
                    'bullets' => ['Tailwind CSS, Bootstrap & Vanilla ESM', 'AI API & Deep Learning Integration', 'Technical SEO Audits & Core Web Vitals'],
                    'icon'    => 'sparkles',
                ],
            ],
            'processSteps'     => [
                [
                    'step'  => '01',
                    'name'  => 'REQUIREMENTS & SQL DESIGN',
                    'desc'  => 'Gather client business requirements, map user journeys, and design clean MySQL/PostgreSQL database schemas and API contracts.',
                    'meta'  => 'SPEC // ARCHITECTURE',
                ],
                [
                    'step'  => '02',
                    'name'  => 'FULL-STACK DEVELOPMENT',
                    'desc'  => 'Build modular backends in PHP (Laravel / CodeIgniter 4) paired with responsive, accessible Tailwind CSS and JavaScript frontends.',
                    'meta'  => 'BUILD // PHP + TAILWIND',
                ],
                [
                    'step'  => '03',
                    'name'  => 'QA, POSTMAN & PHPUNIT',
                    'desc'  => 'Verify every REST endpoint with Postman, write automated PHPUnit tests, and run debugging scripts to eliminate anomalies before launch.',
                    'meta'  => 'QA // VERIFICATION',
                ],
                [
                    'step'  => '04',
                    'name'  => 'LINUX DEPLOYMENT & SUPPORT',
                    'desc'  => 'Deploy to production Linux servers, perform technical SEO & performance audits, and provide continuous evolutionary maintenance.',
                    'meta'  => 'SHIP // PRODUCTION',
                ],
            ],
            'meta' => [
                'title'       => 'Mostepha Amine Bdeira // Full-Stack Web Developer & QA Specialist (mabdeira.dev)',
                'description' => 'Portfolio of Mostepha Amine Bdeira — Full-Stack Web Developer (PHP, CodeIgniter 4, Laravel, MySQL, PostgreSQL, Tailwind CSS) & QA Tester in Lyon, France.',
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
                'building'   => 'Bespoke PHP (Laravel / CodeIgniter 4) web platforms & e-commerce systems in Lyon',
                'learning'   => 'Advanced QA Automation (POEI Testeur QA), Postman contract pipelines & AI-assisted workflows',
                'education'  => 'Master in Intelligent Computer Systems (ENIC-NARIC Level 7 recognized in France)',
                'languages'  => 'French (Professional B2) · English (Fluent C1) · Arabic (Native)',
            ],
            'meta' => [
                'title'       => 'About // Mostepha Amine Bdeira — Full-Stack Developer & QA (mabdeira.dev)',
                'description' => '8+ years freelance Full-Stack Web Developer, 30+ projects delivered, Master in Intelligent Computer Systems (Level 7), based in Lyon, France.',
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
                'title'       => '404 // Page Not Found — Mostepha Amine Bdeira (mabdeira.dev)',
                'description' => 'The requested URL does not exist on mabdeira.dev.',
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
