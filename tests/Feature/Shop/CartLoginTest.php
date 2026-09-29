<?php

namespace Tests\Feature\Shop;

use App\Facades\Cart;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_logging_in_merges_the_guest_cart_with_the_saved_one()
    {
        $user = User::factory()->create();
        $saved = Smartphone::factory()->create(['quantity' => 5]);
        $guest = Smartphone::factory()->create(['quantity' => 5]);
        $this->actingAs($user)->post('/cart', ['id' => $saved->id, 'quantity' => 2]);
        $this->post('/logout');

        $this->post('/cart', ['id' => $saved->id, 'quantity' => 1]);
        $this->post('/cart', ['id' => $guest->id, 'quantity' => 1]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $this->assertSame(3, Cart::quantityOf($saved->id));
        $this->assertSame(1, Cart::quantityOf($guest->id));
    }

    public function test_a_failed_login_keeps_the_guest_cart()
    {
        $user = User::factory()->create();
        $phone = Smartphone::factory()->create();
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password'])->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertSame(1, Cart::count());
    }

    public function test_a_session_from_the_old_cart_package_still_works()
    {
        $phone = Smartphone::factory()->create();

        $this->withSession(['cart' => ['default' => 'old package data']])->get('/cart')->assertOk();
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1])->assertRedirect(route('cart'));

        $this->assertSame(1, Cart::count());
    }

    public function test_a_remembered_login_restores_the_saved_cart()
    {
        $user = User::factory()->create();
        $phone = Smartphone::factory()->create(['quantity' => 5]);
        Cart::add($phone, 2);
        Cart::store($user->email);
        Cart::destroy();

        event(new Login('web', $user, true));

        $this->assertSame(2, Cart::quantityOf($phone->id));
        $this->assertDatabaseMissing('shoppingcarts', ['identifier' => $user->email]);
    }

    public function test_logging_out_with_an_empty_cart_keeps_the_cart_saved_elsewhere()
    {
        $user = User::factory()->create();
        $phone = Smartphone::factory()->create(['quantity' => 5]);
        $this->actingAs($user)->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $this->post('/logout');

        // another device with an empty cart
        $this->actingAs($user)->post('/logout');
        $this->assertDatabaseHas('shoppingcarts', ['identifier' => $user->email]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertSame(2, Cart::quantityOf($phone->id));
    }
}
