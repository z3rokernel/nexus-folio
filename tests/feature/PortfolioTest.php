<?php

namespace Tests\Feature;

use App\Database\Seeds\DatabaseSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class PortfolioTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';
    protected $seed        = DatabaseSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();
        cache()->clean();
    }

    public function testHomePageReturns200AndRendersHeroAndFeaturedProjects(): void
    {
        $result = $this->get('/');

        $result->assertStatus(200);
        $result->assertSee('MOSTEPHA AMINE');
        $result->assertSee('SHOPPING FRANCE');
        $result->assertHeader('Content-Security-Policy');
        $result->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    public function testWorkArchiveAndTagFilteringReturn200(): void
    {
        $all = $this->get('work');
        $all->assertStatus(200);
        $all->assertSee('SELECTED');
        $all->assertSee('SHOPPING FRANCE');

        $filtered = $this->get('work?tag=open-source');
        $filtered->assertStatus(200);
        $filtered->assertSee('MABDEIRA SHADER LAB');
    }

    public function testCaseStudyPageReturns200ForValidSlugAnd404ForUnknownSlug(): void
    {
        $valid = $this->get('work/shopping-france');
        $valid->assertStatus(200);
        $valid->assertSee('SHOPPING FRANCE');
        $valid->assertSee('PROBLEM STATEMENT');

        $notFound = $this->get('work/nope-non-existent-scene');
        $notFound->assertStatus(404);
        $notFound->assertSee('SIGNAL LOST');
    }

    public function testAboutContactGitHubApiAndSitemapReturn200(): void
    {
        $about = $this->get('about');
        $about->assertStatus(200);
        $about->assertSee('MABDEIRA.DEV TERMINAL');

        $contact = $this->get('contact');
        $contact->assertStatus(200);
        $contact->assertSee('CONTACT');

        $github = $this->get('api/github');
        $github->assertStatus(200);
        $json = json_decode($github->response()->getBody(), true);
        $this->assertIsArray($json);
        $this->assertArrayHasKey('weeks', $json);
        $this->assertCount(52, $json['weeks']);

        $sitemap = $this->get('sitemap.xml');
        $sitemap->assertStatus(200);
        $sitemap->assertSee('<urlset');
        $sitemap->assertSee('work/shopping-france');
    }

    public function testContactFormValidationAndValidSubmission(): void
    {
        // Invalid submission (message < 20 chars)
        $invalid = $this->withHeaders(['Accept' => 'application/json'])
            ->post('contact', [
                csrf_token() => csrf_hash(),
                'name'       => 'Alex',
                'email'      => 'alex@studio.ai',
                'message'    => 'Too short',
            ]);

        $invalid->assertStatus(422);

        // Valid submission
        $valid = $this->withHeaders(['Accept' => 'application/json'])
            ->post('contact', [
                csrf_token() => csrf_hash(),
                'name'       => 'Alex Vance',
                'email'      => 'alex@studio.ai',
                'message'    => 'We would like to commission a real-time WebGL & AI launch platform for Q3.',
            ]);

        $valid->assertStatus(200);
        $this->seeInDatabase('messages', [
            'name'  => 'Alex Vance',
            'email' => 'alex@studio.ai',
        ]);
    }

    public function testContactFormHoneypotBlocksBots(): void
    {
        $this->expectException(\CodeIgniter\Honeypot\Exceptions\HoneypotException::class);

        $this->withHeaders(['Accept' => 'application/json'])
            ->post('contact', [
                csrf_token() => csrf_hash(),
                'name'       => 'Spam Bot',
                'email'      => 'bot@spam.net',
                'message'    => 'Automated spam payload that is more than twenty characters long.',
                'honeypot'   => 'http://malicious-link.example',
            ]);
    }

    public function testContactThrottleFilterReturns429OnSixthCall(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $res = $this->withHeaders(['Accept' => 'application/json'])
                ->post('contact', [
                    csrf_token() => csrf_hash(),
                    'name'       => 'Rapid Tester',
                    'email'      => 'rapid@studio.ai',
                    'message'    => 'Testing rate limit filter with a valid message over twenty characters.',
                ]);
            $res->assertStatus(200);
        }

        $sixth = $this->withHeaders(['Accept' => 'application/json'])
            ->post('contact', [
                csrf_token() => csrf_hash(),
                'name'       => 'Rapid Tester',
                'email'      => 'rapid@studio.ai',
                'message'    => 'Testing rate limit filter with a valid message over twenty characters.',
            ]);
        $sixth->assertStatus(429);
    }
}
