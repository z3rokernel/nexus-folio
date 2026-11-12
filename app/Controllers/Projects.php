<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Projects extends BaseController
{
    public function index(): string
    {
        $projectModel = new ProjectModel();
        $activeTag    = $this->request->getGet('tag');
        $activeTag    = is_string($activeTag) && $activeTag !== '' ? strtolower(trim($activeTag)) : 'all';

        $allProjects  = $projectModel->getPublished();
        $filtered     = $activeTag === 'all' ? $allProjects : $projectModel->getPublished($activeTag);

        $tags = ['all', 'web', 'ai', 'webgl', 'mobile', 'open-source'];

        $data = $this->withSiteContext([
            'namespace'   => 'work',
            'projects'    => $filtered,
            'allProjects' => $allProjects,
            'activeTag'   => $activeTag,
            'tags'        => $tags,
            'meta'        => [
                'title'       => 'Selected Work & Projects // Mostepha Amine Bdeira (mabdeira.dev)',
                'description' => 'Explore 30+ custom web, e-commerce, AI, and QA projects engineered with PHP, CodeIgniter 4, Laravel, MySQL, PostgreSQL, and Tailwind CSS.',
                'canonical'   => base_url('work'),
                'og_type'     => 'website',
            ],
        ]);

        return view('pages/work', $data);
    }

    public function show(string $slug): string
    {
        $projectModel = new ProjectModel();
        $project      = $projectModel->getBySlug($slug);

        if (! $project) {
            throw PageNotFoundException::forPageNotFound("Project '{$slug}' not found.");
        }

        $data = $this->withSiteContext([
            'namespace' => 'project',
            'project'   => $project,
            'meta'      => [
                'title'       => $project['title'] . ' // Case Study — Mostepha Amine Bdeira',
                'description' => $project['summary'] ?: $project['subtitle'],
                'canonical'   => base_url('work/' . $project['slug']),
                'og_image'    => base_url(ltrim((string) $project['cover_image'], '/')),
                'og_type'     => 'article',
            ],
        ]);

        return view('pages/project', $data);
    }
}
