<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\Maintenance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    private string $storage;

    protected function setUp(): void
    {
        parent::setUp();

        // own storage and an in-memory maintenance flag: tests inside the app container
        // must never write the live site's plan or take it down
        $this->storage = sys_get_temp_dir() . '/wtech-maintenance-test-' . uniqid();
        File::ensureDirectoryExists($this->storage . '/app');
        $this->app->useStoragePath($this->storage);
        config(['app.maintenance.driver' => 'cache', 'app.maintenance.store' => 'array']);
        $this->app->forgetInstance(\Illuminate\Contracts\Foundation\MaintenanceMode::class);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->storage);

        parent::tearDown();
    }

    public function test_a_planned_window_is_announced_in_a_banner()
    {
        Maintenance::savePlan('New payment options.', now()->addHours(5), now()->addHours(6));

        $this->get('/about')->assertSee('Planned maintenance')->assertSee('New payment options.');
    }

    public function test_admin_starts_maintenance_stays_in_and_visitors_see_the_end_time()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put('/admin/maintenance', [
            'action' => 'start',
            'message' => 'Upgrading the shop.',
            'ends_at' => now()->addHour()->timezone(config('demo.reset.timezone'))->format('Y-m-d\TH:i'),
        ])->assertRedirect(route('admin.maintenance'));
        $this->assertTrue(Maintenance::isDown());
        $bypass = $response->getCookie('laravel_maintenance', false);
        $this->assertNotNull($bypass);

        auth()->logout();
        $this->get('/about')->assertStatus(503)->assertSee('We expect to be back at')->assertSee('Upgrading the shop.');
        $this->withUnencryptedCookie('laravel_maintenance', $bypass->getValue())->get('/about')->assertOk();

        $this->actingAs($admin)->withUnencryptedCookie('laravel_maintenance', $bypass->getValue())
            ->delete('/admin/maintenance')->assertRedirect();
        $this->assertFalse(Maintenance::isDown());
        $this->assertNull(Maintenance::plan());
    }

    public function test_only_admins_reach_the_maintenance_page()
    {
        $this->actingAs(User::factory()->create())->get('/admin/maintenance')->assertForbidden();
    }
}
