<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('skills')->truncate();

        $skills = [
            // Backend & Databases
            ['name' => 'PHP 8.2+',               'category' => 'Backend',  'level' => 97, 'icon' => 'server',       'sort_order' => 1],
            ['name' => 'CodeIgniter 4',          'category' => 'Backend',  'level' => 98, 'icon' => 'layers',       'sort_order' => 2],
            ['name' => 'Laravel',                'category' => 'Backend',  'level' => 95, 'icon' => 'box',          'sort_order' => 3],
            ['name' => 'SQL / MySQL',            'category' => 'Backend',  'level' => 96, 'icon' => 'database',     'sort_order' => 4],
            ['name' => 'PostgreSQL',             'category' => 'Backend',  'level' => 93, 'icon' => 'database',     'sort_order' => 5],
            ['name' => 'MVC & REST APIs',        'category' => 'Backend',  'level' => 96, 'icon' => 'network',      'sort_order' => 6],

            // QA, Testing & Debugging
            ['name' => 'PHPUnit Testing',        'category' => 'DevOps',   'level' => 94, 'icon' => 'shield-check', 'sort_order' => 7],
            ['name' => 'Postman & API QA',       'category' => 'DevOps',   'level' => 96, 'icon' => 'check-circle', 'sort_order' => 8],
            ['name' => 'Debugging & Profiling',  'category' => 'DevOps',   'level' => 95, 'icon' => 'terminal',     'sort_order' => 9],
            ['name' => 'Linux Server & Git',     'category' => 'DevOps',   'level' => 92, 'icon' => 'git-branch',   'sort_order' => 10],

            // Frontend & Motion
            ['name' => 'Tailwind CSS',           'category' => 'Frontend', 'level' => 96, 'icon' => 'palette',      'sort_order' => 11],
            ['name' => 'JavaScript (ES6+)',      'category' => 'Frontend', 'level' => 94, 'icon' => 'code-2',       'sort_order' => 12],
            ['name' => 'HTML5 & CSS3',           'category' => 'Frontend', 'level' => 98, 'icon' => 'layout',       'sort_order' => 13],
            ['name' => 'Bootstrap & Responsive', 'category' => 'Frontend', 'level' => 95, 'icon' => 'smartphone',   'sort_order' => 14],
            ['name' => 'GSAP 3 & Three.js',      'category' => 'Frontend', 'level' => 91, 'icon' => 'sparkles',     'sort_order' => 15],

            // AI & Intelligent Systems
            ['name' => 'AI API Integration',     'category' => 'AI',       'level' => 93, 'icon' => 'cpu',          'sort_order' => 16],
            ['name' => 'Deep Learning Systems',  'category' => 'AI',       'level' => 89, 'icon' => 'brain',        'sort_order' => 17],
            ['name' => 'AI-Assisted Dev',        'category' => 'AI',       'level' => 96, 'icon' => 'wand-2',       'sort_order' => 18],

            // Product, SEO & Languages
            ['name' => 'Technical SEO Audits',   'category' => 'Design',   'level' => 93, 'icon' => 'search',       'sort_order' => 19],
            ['name' => 'Requirements & Agile',   'category' => 'Design',   'level' => 95, 'icon' => 'workflow',     'sort_order' => 20],
            ['name' => 'CMS & E-Commerce',       'category' => 'Design',   'level' => 94, 'icon' => 'shopping-bag', 'sort_order' => 21],
        ];

        $this->db->table('skills')->insertBatch($skills);
    }
}
