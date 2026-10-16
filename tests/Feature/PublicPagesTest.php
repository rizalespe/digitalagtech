<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed per test: the in-memory schema is migrated once per process,
        // so the $seed property would only apply if this class ran first.
        $this->seed();
    }

    public static function pages(): array
    {
        return [
            'home' => ['/'],
            'events' => ['/events'],
            'past events' => ['/events?when=past'],
            'event detail' => ['/events/from-idea-to-scale-webinar'],
            'speakers' => ['/speakers'],
            'news' => ['/news'],
            'news detail' => ['/news/computer-vision-is-catching-disease-in-greenhouse-crops'],
            'gallery' => ['/gallery'],
            'self-learning' => ['/programs/self-learning'],
            'incubation' => ['/programs/business-incubation'],
            'login' => ['/login'],
            'register' => ['/register'],
        ];
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public function test_home_shows_seeded_content(): void
    {
        $this->get('/')
            ->assertSee('From Idea to Scale: Startup Pertanian')
            ->assertSee('Ahmad Syaifulloh')
            ->assertSee('Yogyakarta');
    }

    public function test_unknown_event_returns_404(): void
    {
        $this->get('/events/does-not-exist')->assertNotFound();
    }

    public function test_newsletter_subscription_is_stored_once(): void
    {
        $this->post('/newsletter', ['email' => 'Farmer@Example.com'])->assertRedirect();
        $this->post('/newsletter', ['email' => 'farmer@example.com'])->assertRedirect();

        $this->assertDatabaseCount('newsletter_subscribers', 1);
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'farmer@example.com']);
    }
}
