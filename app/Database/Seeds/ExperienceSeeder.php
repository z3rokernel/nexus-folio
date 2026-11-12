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
                'company'     => 'INDEPENDENT // AUTO-ENTREPRENEUR (LYON, FRANCE)',
                'role'        => 'Full-Stack Web Developer (PHP, Laravel, CodeIgniter 4 & QA)',
                'start'       => 'Apr 2026',
                'end'         => 'Present',
                'description' => json_encode([
                    'Developing bespoke web platforms and business applications with PHP 8.2+, Laravel, and CodeIgniter 4.',
                    'Designing high-integrity MySQL and PostgreSQL relational databases tailored to each client’s domain requirements.',
                    'Testing REST APIs with Postman, authoring automated unit/feature tests with PHPUnit, and writing custom debugging scripts.',
                    'Managing full project lifecycles from requirements engineering to Linux server deployment and production support.',
                ]),
                'sort_order'  => 1,
            ],
            [
                'company'     => 'M4B DESIGNS // FREELANCE FULL-STACK STUDIO',
                'role'        => 'Full-Stack Web Developer (30+ Projects Delivered)',
                'start'       => 'Feb 2017',
                'end'         => 'Jun 2025',
                'description' => json_encode([
                    'Delivered 30+ custom web platforms for SMBs, e-commerce brands, and associations across 8+ years.',
                    'Engineered scalable PHP applications (Laravel, CodeIgniter 4) backed by MySQL and PostgreSQL with responsive Tailwind CSS, JavaScript, and Bootstrap interfaces.',
                    'Performed technical SEO audits, integrated CMS platforms, and maintained long-term client systems.',
                    'Led end-to-end delivery: requirements gathering, architecture, development, QA testing, deployment, and client training.',
                ]),
                'sort_order'  => 2,
            ],
            [
                'company'     => 'UNIVERSITÉ CHADLI BENDJEDID (UCBET) // ENIC-NARIC LEVEL 7',
                'role'        => 'Master in Intelligent Computer Systems (Systèmes Informatiques Intelligents)',
                'start'       => '2022',
                'end'         => '2024',
                'description' => json_encode([
                    'Master’s degree officially recognized equivalent to French Master (Level 7) via ENIC-NARIC comparability certificate (2025).',
                    'Master’s Thesis: "Towards a Deep Learning-Based E-learning Platform" — personalized course recommendations & AI-powered automated exercise generation.',
                ]),
                'sort_order'  => 3,
            ],
            [
                'company'     => 'UNIVERSITÉ CHADLI BENDJEDID (UCBET)',
                'role'        => 'Licence (B.Sc.) in Computer Systems (Systèmes Informatiques)',
                'start'       => '2019',
                'end'         => '2022',
                'description' => json_encode([
                    'Core computer science curriculum covering relational databases (SQL), software architecture (MVC), networking, algorithms, and web engineering.',
                ]),
                'sort_order'  => 4,
            ],
        ];

        $this->db->table('experiences')->insertBatch($experiences);
    }
}
