<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('experiences')->truncate();

        $experiences = [
            [
                'company'     => 'NEXUS // INDEPENDENT AI & MOTION STUDIO',
                'role'        => 'Principal Creative Technologist & Full-Stack Architect',
                'start'       => '2024',
                'end'         => 'Present',
                'description' => json_encode([
                    'Architecting cinema-grade web platforms, AI product interfaces, and custom WebGL experiences for global tech & media startups.',
                    'Engineered high-throughput PHP 8.2+ / CodeIgniter 4 backends paired with 60fps GSAP & Three.js frontends.',
                    'Delivered 14+ flagship launches maintaining 95+ Lighthouse Accessibility and sub-2s LCP across mobile viewports.',
                ]),
                'sort_order'  => 1,
            ],
            [
                'company'     => 'AETHER LABS (GENERATIVE SYSTEMS)',
                'role'        => 'Lead Full-Stack & WebGL Engineer',
                'start'       => '2022',
                'end'         => '2024',
                'description' => json_encode([
                    'Spearheaded the browser studio interface for real-time generative video synthesis, scaling to 42,000+ active creators.',
                    'Built custom GLSL post-processing pipelines and reduced WebSocket telemetry latency by 68%.',
                    'Mentored a cross-functional team of 7 frontend, shader, and backend engineers.',
                ]),
                'sort_order'  => 2,
            ],
            [
                'company'     => 'KRONOS DIGITAL DYNAMICS',
                'role'        => 'Senior Backend & Interactive Systems Developer',
                'start'       => '2020',
                'end'         => '2022',
                'description' => json_encode([
                    'Designed and deployed mission-critical APIs, real-time telemetry dashboards, and automated CI/CD pipelines.',
                    'Migrated legacy monoliths to modular CodeIgniter 4 services with comprehensive PHPUnit test coverage.',
                    'Introduced company-wide motion design tokens and WCAG AA accessibility standards.',
                ]),
                'sort_order'  => 3,
            ],
            [
                'company'     => 'OBSIDIAN INTERACTIVE COLLECTIVE',
                'role'        => 'Creative Frontend & Full-Stack Developer',
                'start'       => '2019',
                'end'         => '2020',
                'description' => json_encode([
                    'Crafted award-winning interactive storytelling sites, custom shaders, and bespoke e-commerce platforms.',
                    'Developed reusable GSAP animation orchestration and progressive enhancement patterns.',
                ]),
                'sort_order'  => 4,
            ],
        ];

        $this->db->table('experiences')->insertBatch($experiences);
    }
}
