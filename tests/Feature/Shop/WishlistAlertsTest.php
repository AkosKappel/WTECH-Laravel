<?php

namespace Tests\Feature\Shop;

use App\Models\Smartphone;
use App\Models\User;
use App\Notifications\WishlistAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class WishlistAlertsTest extends TestCase
{
    use RefreshDatabase;

    /** Saves the phone through the admin form with the given changes. */
    private function adminUpdate(Smartphone $phone, array $changes = [])
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->put(route('smartphones.update', $phone), array_merge(
                ['name' => $phone->name, 'price' => $phone->price, 'quantity' => $phone->quantity], $changes))
            ->assertRedirect(route('admin'));
    }

    private function customerWishing(Smartphone $phone)
    {
        $customer = User::factory()->create();
        $customer->wishlist()->attach($phone);

        return $customer;
    }

    public function test_customers_hear_when_a_wishlisted_phone_is_back_in_stock()
    {
        Notification::fake();
        $phone = Smartphone::factory()->create(['price' => 500, 'quantity' => 0]);
        $customer = $this->customerWishing($phone);
        $other = User::factory()->create();

        $this->adminUpdate($phone, ['quantity' => 5]);

        Notification::assertSentTo($customer, WishlistAlert::class, function (WishlistAlert $alert, array $channels) use ($customer) {
            $data = $alert->toArray($customer);

            return $data['reason'] === WishlistAlert::BACK_IN_STOCK && $data['price'] == 500 && $channels === ['database', 'mail'];
        });
        Notification::assertNotSentTo($other, WishlistAlert::class);
    }

    public function test_customers_hear_when_a_wishlisted_phone_gets_cheaper()
    {
        Notification::fake();
        $phone = Smartphone::factory()->create(['price' => 500, 'quantity' => 3]);
        $customer = $this->customerWishing($phone);

        // a sale counts, as it lowers the price a customer pays
        $this->adminUpdate($phone, ['sale_price' => 420]);

        Notification::assertSentTo($customer, WishlistAlert::class, function (WishlistAlert $alert) use ($customer) {
            $data = $alert->toArray($customer);

            return $data['reason'] === WishlistAlert::PRICE_DROP && $data['price'] == 420 && $data['old_price'] == 500;
        });
    }

    public function test_no_alert_when_nothing_relevant_changes()
    {
        Notification::fake();
        $phone = Smartphone::factory()->create(['price' => 500, 'quantity' => 3]);
        $this->customerWishing($phone);

        $this->adminUpdate($phone, ['name' => 'Renamed Phone', 'price' => 550, 'quantity' => 2]);
        // a sale that starts later doesn't change today's price
        $this->adminUpdate($phone->fresh(), ['sale_price' => 400, 'sale_starts_at' => now()->addWeek()->format('Y-m-d H:i')]);

        Notification::assertNothingSent();
    }

    public function test_alerts_are_queued_per_customer()
    {
        Queue::fake();
        $phone = Smartphone::factory()->create(['quantity' => 0]);
        $this->customerWishing($phone);
        $this->customerWishing($phone);

        $this->adminUpdate($phone, ['quantity' => 1]);

        // one job per customer and channel (database and mail)
        Queue::assertPushed(SendQueuedNotifications::class, 4);
    }

    public function test_customers_see_their_alerts_and_mark_them_as_read()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X', 'price' => 500, 'quantity' => 0]);
        $customer = $this->customerWishing($phone);
        $this->adminUpdate($phone, ['quantity' => 4]);

        $this->actingAs($customer)->get(route('notifications'))
            ->assertOk()
            ->assertSee('Nebula Phone X is back in stock for €500.00.')
            ->assertSee('1 unread notification')
            ->assertSee('E-mails are turned off in this demo');

        $alert = $customer->notifications()->first();
        $this->actingAs(User::factory()->create())->patch(route('notifications.read', $alert->id))->assertNotFound();
        $this->actingAs($customer)->patch(route('notifications.read', $alert->id))->assertRedirect();
        $this->assertNotNull($alert->fresh()->read_at);
        $this->actingAs($customer)->get(route('notifications'))->assertDontSee('unread notification');
    }
}
