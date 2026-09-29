<?php

namespace Tests\Feature\Support;

use App\Facades\Cart;
use App\Models\Smartphone;
use App\Support\Cart as CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_the_same_phone_twice_makes_one_line()
    {
        $phone = Smartphone::factory()->create(['price' => 100]);

        Cart::add($phone, 1);
        Cart::add($phone, 2);

        $this->assertCount(1, Cart::content());
        $this->assertSame(3, Cart::count());
        $this->assertSame(3, Cart::quantityOf($phone->id));
        $this->assertEqualsWithDelta(300.0, Cart::total(), 0.001);
    }

    public function test_updating_to_zero_removes_the_line()
    {
        $phone = Smartphone::factory()->create();
        $item = Cart::add($phone, 2);

        Cart::update($item->rowId, 0);

        $this->assertSame(0, Cart::count());
        $this->assertNull(Cart::get($item->rowId));
    }

    public function test_lines_are_kept_in_the_session_as_plain_arrays()
    {
        $phone = Smartphone::factory()->create();

        Cart::add($phone, 1);

        $stored = session(CartService::SESSION_KEY);
        $this->assertIsArray($stored);
        $this->assertIsArray(reset($stored));
        $this->assertSame($phone->id, reset($stored)['id']);
    }

    public function test_unreadable_session_lines_and_the_old_package_key_are_ignored()
    {
        session([CartService::SESSION_KEY => ['junk' => ['id' => 1]], 'cart' => ['default' => 'old package data']]);
        $phone = Smartphone::factory()->create();

        $this->assertSame(0, Cart::count());

        Cart::add($phone, 1);
        $this->assertSame(1, Cart::count());
        $this->assertNull(session('cart'));
    }

    public function test_store_saves_json_and_an_empty_cart_saves_nothing()
    {
        $phone = Smartphone::factory()->create();

        Cart::store('empty@example.com');
        $this->assertDatabaseMissing('shoppingcarts', ['identifier' => 'empty@example.com']);

        Cart::add($phone, 2);
        Cart::store('user@example.com');
        $content = DB::table('shoppingcarts')->where('identifier', 'user@example.com')->value('content');
        $this->assertSame($phone->id, json_decode($content, true)[0]['id']);
        $this->assertSame(2, json_decode($content, true)[0]['qty']);
    }

    public function test_restore_adds_stored_quantities_capped_at_the_stock_and_deletes_the_stored_cart()
    {
        $capped = Smartphone::factory()->create(['quantity' => 3]);
        $other = Smartphone::factory()->create(['quantity' => 10]);
        Cart::add($capped, 2);
        Cart::add($other, 1);
        Cart::store('user@example.com');
        Cart::destroy();

        Cart::add($capped, 2);
        Cart::restore('user@example.com');

        $this->assertSame(3, Cart::quantityOf($capped->id));
        $this->assertSame(1, Cart::quantityOf($other->id));
        $this->assertDatabaseMissing('shoppingcarts', ['identifier' => 'user@example.com']);
    }

    public function test_restore_drops_deleted_and_sold_out_phones_and_uses_current_prices()
    {
        $deleted = Smartphone::factory()->create();
        $soldOut = Smartphone::factory()->create();
        $repriced = Smartphone::factory()->create(['price' => 100]);
        foreach ([$deleted, $soldOut, $repriced] as $phone) {
            Cart::add($phone, 1);
        }
        Cart::store('user@example.com');
        Cart::destroy();
        $deleted->delete();
        $soldOut->update(['quantity' => 0]);
        $repriced->update(['price' => 80]);

        Cart::restore('user@example.com');

        $this->assertSame(1, Cart::count());
        $this->assertEqualsWithDelta(80.0, Cart::get((string) $repriced->id)->price, 0.001);
    }

    public function test_an_unreadable_stored_cart_is_ignored_and_removed()
    {
        $phone = Smartphone::factory()->create();
        DB::table('shoppingcarts')->insert([
            'identifier' => 'user@example.com', 'instance' => 'default',
            'content' => 'O:29:"Illuminate\Support\Collection', // a truncated serialize() of the old package
            'created_at' => now(), 'updated_at' => now(),
        ]);
        Cart::add($phone, 1);

        Cart::restore('user@example.com');

        $this->assertSame(1, Cart::count());
        $this->assertDatabaseMissing('shoppingcarts', ['identifier' => 'user@example.com']);
    }

    public function test_store_with_an_empty_cart_keeps_the_saved_cart()
    {
        $phone = Smartphone::factory()->create(['quantity' => 5]);
        Cart::add($phone, 2);
        Cart::store('user@example.com');
        $before = DB::table('shoppingcarts')->where('identifier', 'user@example.com')->value('content');
        Cart::destroy();

        Cart::store('user@example.com');

        $this->assertSame(1, DB::table('shoppingcarts')->where('identifier', 'user@example.com')->count());
        $after = json_decode(DB::table('shoppingcarts')->where('identifier', 'user@example.com')->value('content'), true);
        $this->assertSame($phone->id, $after[0]['id']);
        $this->assertSame(2, $after[0]['qty']);
        $this->assertSame(1, count($after));
        $this->assertNotNull($before);
        $this->assertSame(0, Cart::count(), 'store() must not change the session cart');
    }

    public function test_stores_from_two_devices_are_merged()
    {
        $a = Smartphone::factory()->create(['quantity' => 5]);
        $b = Smartphone::factory()->create(['quantity' => 5]);
        Cart::add($a, 2);
        Cart::store('user@example.com');
        Cart::destroy();

        Cart::add($b, 1);
        Cart::store('user@example.com');

        $lines = collect(json_decode(DB::table('shoppingcarts')->where('identifier', 'user@example.com')->value('content'), true))->keyBy('id');
        $this->assertSame(2, $lines[$a->id]['qty']);
        $this->assertSame(1, $lines[$b->id]['qty']);
        $this->assertSame(1, Cart::count(), 'store() must not change the session cart');
    }
}
