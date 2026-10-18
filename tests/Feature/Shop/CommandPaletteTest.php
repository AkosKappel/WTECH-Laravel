<?php

namespace Tests\Feature\Shop;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandPaletteTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_get_the_palette_with_the_shop_pages()
    {
        $this->get('/about')
            ->assertOk()
            ->assertSee('<dialog id="command-palette"', false)
            ->assertSee('role="combobox"', false)
            ->assertSee('data-suggest-url="' . route('search.suggest') . '"', false)
            ->assertSee('href="' . route('compare') . '"', false)
            ->assertSee('href="' . route('login') . '"', false)
            ->assertSee('js/command-palette.js', false)
            ->assertDontSee('data-palette-item="Profile"', false)
            ->assertDontSee('href="' . route('admin') . '"', false);
    }

    public function test_signed_in_customers_get_their_account_pages_but_no_admin_pages()
    {
        $this->actingAs(User::factory()->create())->get('/about')
            ->assertSee('data-palette-item="Profile"', false)
            ->assertSee('data-palette-item="My orders"', false)
            ->assertDontSee('data-palette-item="Admin: ', false);
    }

    public function test_admins_get_the_admin_pages()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get('/about')
            ->assertSee('data-palette-item="Admin: Products"', false)
            ->assertSee('data-palette-item="Admin: Orders"', false)
            ->assertSee('href="' . route('admin.maintenance') . '"', false);
    }

    public function test_demo_admins_get_the_products_but_not_the_customer_data()
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_DEMO_ADMIN]))->get('/about')
            ->assertSee('data-palette-item="Admin: Products"', false)
            ->assertSee('data-palette-item="Admin: Add product"', false)
            ->assertDontSee('data-palette-item="Admin: Orders"', false);
    }

    public function test_the_pages_follow_the_language()
    {
        $this->get('/de/about')->assertSee('data-palette-item="Warenkorb"', false)->assertSee('Schnellsuche');
    }
}
