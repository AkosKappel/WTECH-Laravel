<?php

namespace Tests\Feature\Shop;

use App\Models\Order;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderHistoryTest extends TestCase
{
    use RefreshDatabase;

    private function orderFor(User $user, Smartphone $smartphone): Order
    {
        $order = Order::create([
            'total_price' => 200,
            'user_id' => $user->id,
            'delivery_method' => 'Courier Delivery',
            'payment_method' => 'Credit Card',
        ]);
        $order->smartphones()->attach($smartphone->id, ['count' => 2, 'price' => 100]);

        return $order;
    }

    public function test_customers_see_only_their_own_orders()
    {
        $customer = User::factory()->create();
        $mine = $this->orderFor($customer, Smartphone::factory()->create(['name' => 'Nebula Phone X']));
        $theirs = $this->orderFor(User::factory()->create(), Smartphone::factory()->create());

        $this->actingAs($customer)->get('/orders')
            ->assertOk()
            ->assertSee($mine->number)
            ->assertDontSee($theirs->number);

        $this->actingAs($customer)->get(route('orders.show', $mine))->assertOk()->assertSee('Nebula Phone X');
        $this->actingAs($customer)->get(route('orders.show', $theirs))->assertNotFound();
    }

    public function test_guests_must_sign_in_to_see_orders()
    {
        $this->get('/orders')->assertRedirect(route('login'));
    }

    public function test_admins_change_the_status_and_customers_see_it()
    {
        $customer = User::factory()->create();
        $order = $this->orderFor($customer, Smartphone::factory()->create());
        $this->assertSame('new', $order->fresh()->status);

        $this->actingAs($customer)->patch(route('admin.orders.status', $order), ['status' => 'shipped'])->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patch(route('admin.orders.status', $order), ['status' => 'shipped'])->assertRedirect();
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patch(route('admin.orders.status', $order), ['status' => 'lost'])->assertSessionHasErrors('status');

        $this->assertSame('shipped', $order->fresh()->status);
        $this->actingAs($customer)->get('/orders')->assertSee('Shipped');
    }

    public function test_admins_see_all_orders_with_figures()
    {
        $smartphone = Smartphone::factory()->create(['name' => 'Nebula Phone X', 'quantity' => 2]);
        $order = $this->orderFor(User::factory()->create(), $smartphone);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin/orders')
            ->assertOk()
            ->assertSee($order->number)
            ->assertSee('2 sold')
            ->assertSee('Only 2 left');
        $this->actingAs($admin)->get(route('orders.show', $order))->assertOk();
        $this->actingAs(User::factory()->create())->get('/admin/orders')->assertForbidden();
    }
}
