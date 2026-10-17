<?php

namespace Tests\Feature\Admin;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoAdminTest extends TestCase
{
    use RefreshDatabase;

    private function demoAdmin(): User
    {
        $this->post('/demo-admin')->assertRedirect(route('admin'));

        return auth()->user();
    }

    private function product(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Demo Phone',
            'price' => 100,
            'quantity' => 5,
            'brand' => Brand::factory()->create()->name,
            'color' => Color::factory()->create()->name_en,
        ], $overrides);
    }

    public function test_one_click_creates_and_signs_in_a_demo_admin()
    {
        $user = $this->demoAdmin();

        $this->assertTrue($user->isDemoAdmin());
        $this->assertStringEndsWith('@demo.invalid', $user->email);
        $this->get('/admin')->assertOk()->assertSee('Demo admin.');
    }

    public function test_demo_products_are_hidden_from_the_shop()
    {
        $this->demoAdmin();
        $this->post('/smartphones/add', $this->product(['name' => 'Secret Demo Phone']))->assertRedirect(route('admin'));
        $phone = Smartphone::withoutGlobalScopes()->firstWhere('name', 'Secret Demo Phone');
        $this->assertNotNull($phone->demo_owner_id);
        $this->get('/smartphones')->assertSee('Secret Demo Phone');

        auth()->logout();
        $this->get('/smartphones')->assertDontSee('Secret Demo Phone');
        $this->get(route('details', $phone))->assertNotFound();
    }

    public function test_demo_admins_edit_only_their_own_products()
    {
        $shopPhone = Smartphone::factory()->create();
        $this->demoAdmin();

        $this->get(route('smartphones.edit', $shopPhone))->assertForbidden();
        $this->put(route('smartphones.update', $shopPhone), $this->product())->assertForbidden();
        $this->delete(route('smartphones.delete', $shopPhone))->assertForbidden();
        $this->assertDatabaseHas('smartphones', ['id' => $shopPhone->id, 'name' => $shopPhone->name]);
    }

    public function test_demo_admins_see_no_orders_and_cannot_change_the_account()
    {
        $this->demoAdmin();

        $this->get('/admin/orders')->assertForbidden();
        $this->put('/profile', ['email' => 'mine@example.com'])->assertForbidden();
        $this->put('/passwordChange', ['newPassword' => 'whatever123'])->assertForbidden();
    }
}
