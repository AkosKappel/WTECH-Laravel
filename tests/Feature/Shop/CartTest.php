<?php

namespace Tests\Feature\Shop;

use App\Models\Smartphone;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Facades\Cart;
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

    public function test_quantity_change_answers_with_json_for_the_cart_script()
    {
        $phone = Smartphone::factory()->create(['quantity' => 4, 'price' => 100]);
        $other = Smartphone::factory()->create(['quantity' => 5, 'price' => 50]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);
        $this->post('/cart', ['id' => $other->id, 'quantity' => 1]);
        $rowId = Cart::content()->firstWhere('id', $phone->id)->rowId;

        $this->putJson("/cart/{$rowId}", ['product_quantity' => 99])
            ->assertOk()
            ->assertExactJson([
                'qty' => 4,
                'itemTotal' => formattedPrice(400),
                'total' => formattedPrice(450),
                'count' => 5,
            ]);

        $this->putJson('/cart/missing', ['product_quantity' => 1])->assertNotFound();
        $this->putJson("/cart/{$rowId}", ['product_quantity' => 'x'])->assertUnprocessable();
    }

    public function test_a_phone_can_be_removed()
    {
        $phone = Smartphone::factory()->create();
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);
        $rowId = Cart::content()->first()->rowId;

        $this->from('/cart')->delete("/cart/{$rowId}")->assertRedirect('/cart');

        $this->assertEquals(0, Cart::count());
    }

    public function test_cart_is_stored_on_logout_and_login_still_works()
    {
        $user = User::factory()->create();
        $phone = Smartphone::factory()->create();

        $this->actingAs($user)->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $this->post('/logout');
        $this->assertDatabaseHas('shoppingcarts', ['identifier' => $user->email]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticatedAs($user);
    }

    public function test_cart_is_kept_across_logout_and_login()
    {
        $user = User::factory()->create();
        $phone = Smartphone::factory()->create();

        $this->actingAs($user)->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $this->post('/logout');
        $this->assertDatabaseHas('shoppingcarts', ['identifier' => $user->email]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals(2, Cart::count());
    }

    public function test_updating_or_removing_an_unknown_line_redirects_and_changes_nothing()
    {
        $phone = Smartphone::factory()->create(['quantity' => 5]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 2]);

        $this->put('/cart/99999', ['product_quantity' => 1])->assertRedirect();
        $this->delete('/cart/99999')->assertRedirect();

        $this->assertSame(2, Cart::count());
        $this->assertSame(2, Cart::quantityOf($phone->id));
    }

    public function test_a_line_total_with_cents_is_shown_correctly()
    {
        $phone = Smartphone::factory()->create(['price' => 19.99, 'quantity' => 5]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 3]);

        $this->get('/cart')->assertOk()->assertSee('59,97 €');
    }
}
