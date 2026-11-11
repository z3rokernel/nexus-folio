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

        $tags = ['all', 'ai', 'webgl', 'web', 'mobile', 'open-source'];

        $data = $this->withSiteContext([
            'namespace'   => 'work',
            'projects'    => $filtered,
            'allProjects' => $allProjects,
            'activeTag'   => $activeTag,
            'tags'        => $tags,
            'meta'        => [
                'title'       => 'WORK ARCHIVE // Selected Scenes & Engineering Case Studies — NEXUS-FOLIO',
                'description' => 'Explore interactive WebGL, AI systems, and full-stack CodeIgniter 4 case studies by Mostepha Amine BDEIR.',
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
            throw PageNotFoundException::forPageNotFound("Project scene '{$slug}' not found.");
        }

        $data = $this->withSiteContext([
            'namespace' => 'project',
            'project'   => $project,
            'meta'      => [
                'title'       => $project['title'] . ' // Case Study — NEXUS-FOLIO',
                'description' => $project['summary'] ?: $project['subtitle'],
                'canonical'   => base_url('work/' . $project['slug']),
                'og_image'    => base_url(ltrim((string) $project['cover_image'], '/')),
                'og_type'     => 'article',
            ],
        ]);

        return view('pages/project', $data);
    }
}
