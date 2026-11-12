<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('ProjectSeeder');
        $this->call('SkillSeeder');
        $this->call('ExperienceSeeder');
    }
}

