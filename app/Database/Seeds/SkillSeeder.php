<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('skills')->truncate();

        $skills = [
            // Backend
            ['name' => 'PHP 8.3', 'category' => 'Backend', 'level' => 96, 'icon' => 'server', 'sort_order' => 1],
            ['name' => 'CodeIgniter 4', 'category' => 'Backend', 'level' => 98, 'icon' => 'layers', 'sort_order' => 2],
            ['name' => 'MySQL / SQLite', 'category' => 'Backend', 'level' => 94, 'icon' => 'database', 'sort_order' => 3],
            ['name' => 'REST & GraphQL', 'category' => 'Backend', 'level' => 92, 'icon' => 'network', 'sort_order' => 4],
            ['name' => 'Redis & Caching', 'category' => 'Backend', 'level' => 90, 'icon' => 'zap', 'sort_order' => 5],

            // Frontend & Motion
            ['name' => 'GSAP 3 + ScrollTrigger', 'category' => 'Frontend', 'level' => 98, 'icon' => 'sparkles', 'sort_order' => 6],
            ['name' => 'Three.js & WebGL', 'category' => 'Frontend', 'level' => 94, 'icon' => 'box', 'sort_order' => 7],
            ['name' => 'Custom GLSL Shaders', 'category' => 'Frontend', 'level' => 91, 'icon' => 'flame', 'sort_order' => 8],
            ['name' => 'Vanilla ES Modules', 'category' => 'Frontend', 'level' => 97, 'icon' => 'code-2', 'sort_order' => 9],
            ['name' => 'Tailwind CSS v4', 'category' => 'Frontend', 'level' => 96, 'icon' => 'palette', 'sort_order' => 10],
            ['name' => 'Barba.js & Lenis', 'category' => 'Frontend', 'level' => 95, 'icon' => 'workflow', 'sort_order' => 11],

            // AI & Creative Tech
            ['name' => 'LLM & Agent Pipelines', 'category' => 'AI', 'level' => 93, 'icon' => 'cpu', 'sort_order' => 12],
            ['name' => 'RAG & Vector Search', 'category' => 'AI', 'level' => 90, 'icon' => 'brain', 'sort_order' => 13],
            ['name' => 'Generative Media APIs', 'category' => 'AI', 'level' => 92, 'icon' => 'wand-2', 'sort_order' => 14],
            ['name' => 'WebAudio DSP', 'category' => 'AI', 'level' => 86, 'icon' => 'activity', 'sort_order' => 15],

            // DevOps & Quality
            ['name' => 'Docker & CI/CD', 'category' => 'DevOps', 'level' => 91, 'icon' => 'container', 'sort_order' => 16],
            ['name' => 'GitHub Actions', 'category' => 'DevOps', 'level' => 93, 'icon' => 'git-branch', 'sort_order' => 17],
            ['name' => 'PHPUnit & TDD', 'category' => 'DevOps', 'level' => 92, 'icon' => 'shield-check', 'sort_order' => 18],
            ['name' => 'Linux / Nginx', 'category' => 'DevOps', 'level' => 89, 'icon' => 'terminal', 'sort_order' => 19],

            // Design & Architecture
            ['name' => 'Creative Direction', 'category' => 'Design', 'level' => 94, 'icon' => 'eye', 'sort_order' => 20],
            ['name' => 'Design Systems', 'category' => 'Design', 'level' => 95, 'icon' => 'grid', 'sort_order' => 21],
            ['name' => 'WCAG Accessibility', 'category' => 'Design', 'level' => 94, 'icon' => 'check-circle', 'sort_order' => 22],
        ];

        $this->db->table('skills')->insertBatch($skills);
    }
}
