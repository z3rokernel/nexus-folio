<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Merge global site context (profile, navigation, command palette projects) into view data.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function withSiteContext(array $data = []): array
    {
        $projectModel = new ProjectModel();
        $paletteProjects = $projectModel->getPublished();

        $site = [
            'name'         => (string) env('PORTFOLIO_NAME', 'Mostepha Amine BDEIR'),
            'handle'       => (string) env('PORTFOLIO_HANDLE', 'NXS//STUDIO'),
            'city'         => (string) env('PORTFOLIO_CITY', 'Paris, France'),
            'timezone'     => (string) env('PORTFOLIO_TIMEZONE', 'Europe/Paris'),
            'email'        => (string) env('PORTFOLIO_EMAIL', 'contact@nexus-folio.dev'),
            'availability' => (string) env('PORTFOLIO_AVAILABILITY', 'Open to select freelance & full-time roles'),
            'github_user'  => (string) env('GITHUB_USER', 'aminebdeir'),
            'roles'        => ['Full-Stack Developer', 'Creative Technologist', 'AI Systems Builder'],
            'socials'      => [
                ['label' => 'GitHub',   'url' => 'https://github.com/' . env('GITHUB_USER', 'aminebdeir'), 'icon' => 'github'],
                ['label' => 'LinkedIn', 'url' => 'https://linkedin.com/in/mostepha-amine-bdeir',          'icon' => 'linkedin'],
                ['label' => 'X // Twitter', 'url' => 'https://x.com/nexusfolio',                          'icon' => 'twitter'],
            ],
        ];

        return array_merge([
            'site'            => $site,
            'paletteProjects' => $paletteProjects,
        ], $data);
    }
}
