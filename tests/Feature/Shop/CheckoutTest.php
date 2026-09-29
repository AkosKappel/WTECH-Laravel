<?php

namespace Tests\Feature\Shop;

use App\Models\Order;
use App\Models\Smartphone;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function address(array $overrides = [])
    {
        return array_merge([
            'first_name' => 'Jana',
            'last_name' => 'Nováková',
            'phone_number' => '+421 900 123 456',
            'email' => 'jana@example.com',
            'street' => 'Hlavná',
            'descriptive_number' => '12',
            'city' => 'Bratislava',
            'country' => 'Slovakia',
        ], $overrides);
    }

    private function checkoutUpToPayment()
    {
        $this->put('/address', $this->address())->assertRedirect(route('delivery'));
        $this->post('/delivery', ['transport' => 'Courier Delivery'])->assertRedirect(route('payment'));
    }

    public function test_guest_can_order_and_stock_goes_down()
    {
        $phone = Smartphone::factory()->create(['price' => 199.99, 'quantity' => 5]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 2]);

        $this->checkoutUpToPayment();
        $this->post('/payment', ['payment' => 'Cash on Delivery'])->assertRedirect(route('order.complete'));

        $user = User::firstWhere('email', 'jana@example.com');
        $this->assertNotNull($user);
        $this->assertNull($user->password);
        $order = Order::firstWhere('user_id', $user->id);
        $this->assertEqualsWithDelta(399.98, $order->total_price, 0.001);
        $this->assertDatabaseHas('order_smartphone', ['order_id' => $order->id, 'smartphone_id' => $phone->id, 'count' => 2]);
        $this->assertEquals(3, $phone->fresh()->quantity);
        $this->assertEquals(0, Cart::count());
        $this->get(route('order.complete'))->assertOk();
    }

    public function test_payment_with_an_empty_cart_goes_back_to_the_cart()
    {
        $this->checkoutUpToPayment();

        $this->post('/payment', ['payment' => 'Cash on Delivery'])
            ->assertRedirect(route('cart'))
            ->assertSessionHasErrors('cart');
        $this->assertEquals(0, Order::count());
    }

    public function test_order_is_refused_when_stock_ran_out_meanwhile()
    {
        $phone = Smartphone::factory()->create(['quantity' => 5]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $phone->update(['quantity' => 1]);

        $this->checkoutUpToPayment();
        $this->post('/payment', ['payment' => 'Cash on Delivery'])
            ->assertRedirect(route('cart'))
            ->assertSessionHasErrors('cart');

        $this->assertEquals(0, Order::count());
        $this->assertEquals(1, $phone->fresh()->quantity);
    }

    public function test_unknown_delivery_method_is_rejected()
    {
        $this->post('/delivery', ['transport' => 'Teleport'])->assertSessionHasErrors('transport');
    }

    public function test_guest_cannot_use_the_email_of_a_registered_account()
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->put('/address', $this->address(['email' => 'taken@example.com']))->assertSessionHasErrors('email');
    }

    public function test_guest_can_create_an_account_after_ordering()
    {
        $phone = Smartphone::factory()->create();
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);
        $this->checkoutUpToPayment();
        $this->post('/payment', ['payment' => 'Cash on Delivery', 'create_account' => '1']);

        $this->post('/finishRegister', ['password' => 'secret-pass-123', 'password_confirmation' => 'secret-pass-123']);

        $this->assertNotNull(User::firstWhere('email', 'jana@example.com')->password);
    }
}
