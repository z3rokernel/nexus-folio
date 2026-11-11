<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSkillsTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'level' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 90,
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('skills', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('skills', true);
    }
}
