<?php

namespace Tests\Feature\Shop;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    private function checkout()
    {
        $this->put('/address', [
            'first_name' => 'Jana', 'last_name' => 'Nováková', 'phone_number' => '+421 900 123 456',
            'email' => 'jana@example.com', 'street' => 'Hlavná', 'descriptive_number' => '12',
            'city' => 'Bratislava', 'country' => 'Slovakia',
        ]);
        $this->post('/delivery', ['transport' => 'Courier Delivery']);
        $this->post('/payment', ['payment' => 'Cash on Delivery'])->assertRedirect(route('order.complete'));

        return Order::latest('id')->first();
    }

    public function test_sale_prices_show_and_are_charged()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X', 'price' => 500, 'sale_price' => 400]);
        Smartphone::factory()->create(['name' => 'Full Price Phone', 'price' => 300]);
        Smartphone::factory()->create(['name' => 'Expired Sale Phone', 'price' => 300, 'sale_price' => 200, 'sale_ends_at' => now()->subDay()]);

        $this->get('/smartphones?sale=on')
            ->assertSee('Nebula Phone X')->assertSee('−20 %')
            ->assertDontSee('Full Price Phone')->assertDontSee('Expired Sale Phone');

        $this->post('/cart', ['id' => $phone->id, 'quantity' => 2]);
        $order = $this->checkout();
        $this->assertEqualsWithDelta(800, $order->total_price, 0.001);
        $this->assertDatabaseHas('order_smartphone', ['order_id' => $order->id, 'price' => 400]);
    }

    public function test_biggest_discount_sorts_first_and_price_filter_uses_the_sale_price()
    {
        Smartphone::factory()->create(['name' => 'Small Deal', 'price' => 500, 'sale_price' => 450]);
        Smartphone::factory()->create(['name' => 'Big Deal', 'price' => 500, 'sale_price' => 250]);

        $this->get('/smartphones?sort=discount')->assertSeeInOrder(['Big Deal', 'Small Deal']);
        $this->get('/smartphones?price=-300')->assertSee('Big Deal')->assertDontSee('Small Deal');
    }

    public function test_a_code_is_applied_in_the_cart_and_stored_on_the_order()
    {
        DiscountCode::create(['code' => 'DEMO10', 'type' => 'percent', 'value' => 10, 'usage_limit' => 1]);
        $phone = Smartphone::factory()->create(['price' => 200]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);

        $this->from('/cart')->post('/cart/code', ['code' => 'nope'])->assertSessionHasErrors('code');
        $this->from('/cart')->post('/cart/code', ['code' => 'demo10'])->assertSessionHasNoErrors();
        $this->get('/cart')->assertSee('DEMO10')->assertSee('−€20.00');

        $order = $this->checkout();
        $this->assertEqualsWithDelta(180, $order->total_price, 0.001);
        $this->assertEqualsWithDelta(20, $order->discount, 0.001);
        $this->assertSame('DEMO10', $order->discount_code);
        $this->assertSame(1, DiscountCode::first()->used_count);

        // used up now
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);
        $this->from('/cart')->post('/cart/code', ['code' => 'DEMO10'])->assertSessionHasErrors('code');
    }

    public function test_a_code_below_its_minimum_order_takes_nothing_off()
    {
        DiscountCode::create(['code' => 'SAVE50', 'type' => 'fixed', 'value' => 50, 'min_order' => 500]);
        $phone = Smartphone::factory()->create(['price' => 200]);
        $this->post('/cart', ['id' => $phone->id, 'quantity' => 1]);

        $this->from('/cart')->post('/cart/code', ['code' => 'SAVE50'])->assertSessionHasErrors('code');
    }

    public function test_admins_manage_codes_and_sale_prices_must_be_lower()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/codes', ['code' => 'spring', 'type' => 'percent', 'value' => 15, 'active' => '1'])
            ->assertRedirect(route('admin.codes'));
        $this->assertDatabaseHas('discount_codes', ['code' => 'SPRING', 'value' => 15]);
        $this->actingAs($admin)->post('/admin/codes', ['code' => 'bad', 'type' => 'percent', 'value' => 150])->assertSessionHasErrors('value');
        $this->actingAs(User::factory()->create())->get('/admin/codes')->assertForbidden();

        $phone = Smartphone::factory()->create(['price' => 100]);
        $this->actingAs($admin)->put(route('smartphones.update', $phone), [
            'name' => $phone->name, 'price' => 100, 'quantity' => 5, 'sale_price' => 120,
        ])->assertSessionHasErrors('sale_price');
    }
}
