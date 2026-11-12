<?php

namespace App\Models;

use CodeIgniter\Model;

class SkillModel extends Model
{
    protected $table            = 'skills';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'category',
        'level',
        'icon',
        'sort_order',
    ];

    /**
     * Get all skills ordered by sort_order.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllOrdered(): array
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * Group skills by category.
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function getGroupedByCategory(): array
    {
        $skills  = $this->getAllOrdered();
        $grouped = [];
        foreach ($skills as $skill) {
            $cat = $skill['category'] ?? 'General';
            $grouped[$cat][] = $skill;
        }

        return $grouped;
    }
}

