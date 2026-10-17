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

    /**
     * Real maintenance mode, kept in the array cache: the default file driver would take
     * down the live site when the tests run inside the app container.
     */
    private function down(array $options)
    {
        config(['app.maintenance.driver' => 'cache', 'app.maintenance.store' => 'array']);
        $this->app->forgetInstance(\Illuminate\Contracts\Foundation\MaintenanceMode::class);
        $this->app->maintenanceMode()->activate($options);
    }

    public function test_maintenance_page_shows_the_expected_wait()
    {
        $this->down(['retry' => 600]);

        $this->get('/about')->assertStatus(503)->assertSee('try again in about 10 minutes');
    }

    public function test_maintenance_gives_live_updates_a_json_answer()
    {
        $this->down([]);

        // catalog-filters.js and cart.js ask for JSON and load the full page when they get an error
        $this->getJson('/smartphones')->assertStatus(503)->assertExactJson(['message' => 'Service Unavailable']);
    }

    public function test_missing_pages_show_the_404_page()
    {
        $this->get('/no-such-page-xyz')
            ->assertNotFound()
            ->assertSee('Page not found');
    }
}
