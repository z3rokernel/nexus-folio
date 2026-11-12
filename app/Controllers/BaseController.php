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
            'name'         => (string) env('PORTFOLIO_NAME', 'Mostepha Amine Bdeira'),
            'handle'       => (string) env('PORTFOLIO_HANDLE', 'MABDEIRA.DEV'),
            'city'         => (string) env('PORTFOLIO_CITY', 'Lyon, France'),
            'timezone'     => (string) env('PORTFOLIO_TIMEZONE', 'Europe/Paris'),
            'email'        => (string) env('PORTFOLIO_EMAIL', 'contact@mabdeira.dev'),
            'alt_email'    => 'bdeiramostephamine@pm.me',
            'phone'        => (string) env('PORTFOLIO_PHONE', '+33 6 15 21 88 14'),
            'availability' => (string) env('PORTFOLIO_AVAILABILITY', 'Open to Full-Stack PHP/Laravel/CI4, QA & Freelance roles'),
            'github_user'  => (string) env('GITHUB_USER', 'z3rokernel'),
            'roles'        => [
                'Full-Stack Web Developer',
                'PHP · Laravel · CodeIgniter 4',
                'QA Tester & REST API Specialist',
                'SQL · MySQL · PostgreSQL Architect',
            ],
            'socials'      => [
                ['label' => 'GitHub',   'url' => 'https://github.com/z3rokernel',        'icon' => 'github'],
                ['label' => 'LinkedIn', 'url' => 'https://linkedin.com/in/m4b007',       'icon' => 'linkedin'],
                ['label' => 'Email',    'url' => 'mailto:contact@mabdeira.dev',          'icon' => 'mail'],
            ],
        ];

        return array_merge([
            'site'            => $site,
            'paletteProjects' => $paletteProjects,
        ], $data);
    }
}
