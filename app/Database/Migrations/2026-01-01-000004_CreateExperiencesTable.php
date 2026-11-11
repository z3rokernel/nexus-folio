<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExperiencesTable extends Migration
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
            'company' => [
                'type'       => 'VARCHAR',
                'constraint' => 140,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 140,
            ],
            'start' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'end' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'default'    => 'Present',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('experiences', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('experiences', true);
    }
}
