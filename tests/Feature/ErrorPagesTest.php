<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.debug' => false]);

        Route::middleware('web')->get('/_test/boom', fn () => throw new \RuntimeException('secret-detail-123'));
    }

    public function test_server_errors_show_the_error_page_without_details_in_production()
    {
        $this->get('/_test/boom')
            ->assertStatus(500)
            ->assertSee('ERR-')
            ->assertDontSee('secret-detail-123');
    }

    public function test_server_errors_return_a_json_reference()
    {
        $response = $this->getJson('/_test/boom')
            ->assertStatus(500)
            ->assertJsonStructure(['message', 'reference']);

        $this->assertStringNotContainsString('secret-detail-123', $response->getContent());
        $this->assertMatchesRegularExpression('/^ERR-[0-9A-F]{6}$/', $response->json('reference'));
    }

    public function test_missing_pages_show_the_404_page()
    {
        $this->get('/no-such-page-xyz')
            ->assertNotFound()
            ->assertSee('Page not found');
    }
}
