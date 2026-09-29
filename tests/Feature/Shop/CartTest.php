<?php

namespace Tests\Feature\Shop;

use App\Models\Smartphone;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_a_phone_puts_it_in_the_cart()
    {
        $phone = Smartphone::factory()->create();

        $this->post('/cart', ['id' => $phone->id, 'quantity' => 2])->assertRedirect(route('cart'));

        $this->assertEquals(2, Cart::count());
        $this->get('/cart')->assertOk()->assertSee($phone->name);
    }

    public function test_price_and_name_come_from_the_database()
    {
        $phone = Smartphone::factory()->create(['price' => 499.0]);

        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1, 'price' => 1, 'name' => 'Cheap']);

        $item = Cart::content()->first();
        $this->assertEquals(499.0, $item->price);
        $this->assertEquals($phone->name, $item->name);
    }

    public function test_quantity_is_capped_at_the_stock()
    {
        $phone = Smartphone::factory()->create(['quantity' => 3]);

        $this->post('/cart', ['id' => $phone->id, 'quantity' => 5]);
        $this->assertEquals(3, Cart::count());

        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1])->assertSessionHasErrors('quantity');
        $this->assertEquals(3, Cart::count());
    }

    public function test_quantity_can_be_changed_up_to_the_stock()
    {
        $phone = Smartphone::factory()->create(['quantity' => 4]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $rowId = Cart::content()->first()->rowId;

        $this->put("/cart/{$rowId}", ['product_quantity' => 1])->assertRedirect(route('cart'));
        $this->assertEquals(1, Cart::count());

        $this->put("/cart/{$rowId}", ['product_quantity' => 99]);
        $this->assertEquals(4, Cart::count());
    }

    public function test_a_phone_can_be_removed()
    {
        $phone = Smartphone::factory()->create();
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);
        $rowId = Cart::content()->first()->rowId;

        $this->from('/cart')->delete("/cart/{$rowId}")->assertRedirect('/cart');

        $this->assertEquals(0, Cart::count());
    }

    public function test_cart_is_kept_across_logout_and_login()
    {
        $this->markTestIncomplete('Known bug: hardevine/shoppingcart stores serialize() output, whose NUL bytes Postgres truncates, so Cart::restore() fails on login and the cart is lost. Fixed by the own cart class in upgrade Phase 3; remove this line then.');

        $user = User::factory()->create();
        $phone = Smartphone::factory()->create();

        $this->actingAs($user)->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $this->post('/logout');
        $this->assertDatabaseHas('shoppingcarts', ['identifier' => $user->email]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals(2, Cart::count());
    }
}
