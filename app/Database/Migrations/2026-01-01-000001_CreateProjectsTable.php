<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 140,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
            ],
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 2026,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 140,
                'null'       => true,
            ],
            'client' => [
                'type'       => 'VARCHAR',
                'constraint' => 140,
                'null'       => true,
            ],
            'summary' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'challenge' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'approach' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'solution' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'results' => [
                'type' => 'TEXT', // JSON array of metric strings
                'null' => true,
            ],
            'body' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cover_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'cover_video' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'accent' => [
                'type'       => 'VARCHAR',
                'constraint' => 32,
                'default'    => '#D4FF1F',
            ],
            'tags' => [
                'type' => 'TEXT', // JSON array
                'null' => true,
            ],
            'stack' => [
                'type' => 'TEXT', // JSON array
                'null' => true,
            ],
            'live_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'repo_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'published' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('projects', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('projects', true);
    }
}
