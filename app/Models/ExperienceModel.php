<?php

namespace App\Models;

use CodeIgniter\Model;

class ExperienceModel extends Model
{
    protected $table            = 'experiences';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'company',
        'role',
        'start',
        'end',
        'description',
        'sort_order',
    ];

    /**
     * Get all experience entries ordered by sort_order.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getTimeline(): array
    {
        $rows = $this->orderBy('sort_order', 'ASC')->findAll();
        foreach ($rows as &$row) {
            $decoded = json_decode($row['description'] ?? '', true);
            $row['bullets'] = is_array($decoded) ? $decoded : array_filter(explode("\n", (string) $row['description']));
        }

        return $rows;
    }
}
