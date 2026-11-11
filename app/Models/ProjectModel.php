<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'slug',
        'title',
        'subtitle',
        'year',
        'role',
        'client',
        'summary',
        'challenge',
        'approach',
        'solution',
        'results',
        'body',
        'cover_image',
        'cover_video',
        'accent',
        'tags',
        'stack',
        'live_url',
        'repo_url',
        'featured',
        'sort_order',
        'published',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Decode JSON fields on a single project record.
     *
     * @param array<string, mixed>|null $row
     * @return array<string, mixed>|null
     */
    public function hydrateProject(?array $row): ?array
    {
        if (! $row) {
            return null;
        }

        foreach (['tags', 'stack', 'results'] as $jsonField) {
            if (isset($row[$jsonField]) && is_string($row[$jsonField])) {
                $decoded = json_decode($row[$jsonField], true);
                $row[$jsonField] = is_array($decoded) ? $decoded : [];
            } elseif (! isset($row[$jsonField]) || ! is_array($row[$jsonField])) {
                $row[$jsonField] = [];
            }
        }

        return $row;
    }

    /**
     * Hydrate an array of project rows.
     *
     * @param array<int, array<string, mixed>> $rows
     * @return array<int, array<string, mixed>>
     */
    public function hydrateMany(array $rows): array
    {
        return array_map(fn (array $r) => $this->hydrateProject($r), $rows);
    }

    /**
     * Get all published featured projects ordered by sort_order.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getFeatured(int $limit = 6): array
    {
        $rows = $this->where('published', 1)
            ->where('featured', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll($limit);

        return $this->hydrateMany($rows);
    }

    /**
     * Get all published projects, optionally filtered by tag.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPublished(?string $tag = null): array
    {
        $rows = $this->where('published', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $hydrated = $this->hydrateMany($rows);

        if ($tag !== null && $tag !== '' && strtolower($tag) !== 'all') {
            $needle = strtolower(trim($tag));
            $hydrated = array_values(array_filter($hydrated, static function (array $project) use ($needle): bool {
                $tags = array_map('strtolower', $project['tags'] ?? []);
                return in_array($needle, $tags, true);
            }));
        }

        return $hydrated;
    }

    /**
     * Find a single published project by slug, including its media gallery and adjacent (prev/next) projects.
     *
     * @return array<string, mixed>|null
     */
    public function getBySlug(string $slug): ?array
    {
        $row = $this->where('published', 1)
            ->where('slug', $slug)
            ->first();

        $project = $this->hydrateProject($row);
        if (! $project) {
            return null;
        }

        $db = \Config\Database::connect();
        $media = $db->table('project_media')
            ->where('project_id', $project['id'])
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();

        $project['media'] = $media;

        $all = $this->getPublished();
        $count = count($all);
        $currentIndex = 0;
        foreach ($all as $idx => $item) {
            if ($item['slug'] === $slug) {
                $currentIndex = $idx;
                break;
            }
        }

        $project['next_project'] = $count > 1 ? $all[($currentIndex + 1) % $count] : null;
        $project['prev_project'] = $count > 1 ? $all[($currentIndex - 1 + $count) % $count] : null;
        $project['scene_index']  = str_pad((string) ($currentIndex + 1), 2, '0', STR_PAD_LEFT);
        $project['scene_total']  = str_pad((string) $count, 2, '0', STR_PAD_LEFT);

        return $project;
    }
}
