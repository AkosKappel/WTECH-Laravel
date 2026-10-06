<?php

namespace Tests\Feature\Shop;

use App\Models\Image;
use App\Models\Order;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_best_selling_phones()
    {
        $phones = Smartphone::factory()->count(3)->has(Image::factory())->create();

        $response = $this->get('/');

        $response->assertOk();
        foreach ($phones as $phone) {
            $response->assertSee($phone->name);
        }
    }

    public function test_best_selling_ranks_by_recent_sales_and_skips_unshowable_phones()
    {
        [$top, $second, $cheapUnsold, $oldSeller, $flagship] = Smartphone::factory()->count(5)->has(Image::factory())
            ->sequence(['price' => 100], ['price' => 100], ['price' => 200], ['price' => 300], ['price' => 1500])
            ->create();
        Smartphone::factory()->has(Image::factory())->create(['quantity' => 0]);
        Smartphone::factory()->create(); // no image

        $this->order([$second->id => 1, $top->id => 2]);
        $this->order([$second->id => 1, $top->id => 1]);
        $this->order([$oldSeller->id => 50])->forceFill(['created_at' => now()->subDays(91)])->save();

        // phones not sold recently keep the list full, flagships first
        $this->assertEquals(
            [$top->id, $second->id, $flagship->id, $oldSeller->id, $cheapUnsold->id],
            Smartphone::bestSelling()->pluck('id')->all()
        );
    }

    private function order(array $counts): Order
    {
        $order = Order::create([
            'total_price' => 100,
            'user_id' => User::factory()->create()->id,
            'delivery_method' => 'courier',
            'payment_method' => 'card',
        ]);
        foreach ($counts as $id => $count) {
            $order->smartphones()->attach($id, ['count' => $count, 'price' => 100]);
        }

        return $order;
    }

    public function test_catalog_lists_phones()
    {
        $phones = Smartphone::factory()->count(2)->create();

        $this->get('/smartphones')->assertOk()->assertSee($phones[0]->name)->assertSee($phones[1]->name);
    }

    public function test_catalog_filters_by_brand()
    {
        $wanted = Smartphone::factory()->create(['name' => 'Alpha Wanted']);
        Smartphone::factory()->create(['name' => 'Beta Other']);

        $this->followingRedirects()
            ->get('/smartphones?brand=' . Str::slug($wanted->brand->name))
            ->assertOk()
            ->assertSee('Alpha Wanted')
            ->assertDontSee('Beta Other');
    }

    public function test_search_finds_phone_by_name()
    {
        Smartphone::factory()->create(['name' => 'Nebula Phone X']);
        Smartphone::factory()->create(['name' => 'Beta Other']);

        $this->followingRedirects()
            ->get('/smartphones?q=nebula')
            ->assertOk()
            ->assertSee('Nebula Phone X')
            ->assertDontSee('Beta Other');
    }

    public function test_search_suggestions_return_json()
    {
        Smartphone::factory()->create(['name' => 'Nebula Phone X']);
        Smartphone::factory()->create(['name' => 'Beta Other']);

        $this->getJson('/search/suggest?q=nebula')
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('results.0.name', 'Nebula Phone X');
    }

    public function test_product_page_shows_the_phone()
    {
        $phone = Smartphone::factory()->create();

        $this->get(route('details', $phone))->assertOk()->assertSee($phone->name);
    }

    public function test_product_page_has_link_preview_tags()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X']);
        Image::factory()->for($phone)->create(['source' => '/images/products/nebula.svg']);
        Image::factory()->for($phone)->create(['source' => '/images/nebula.jpg']);

        $this->get(route('details', $phone))
            ->assertSee('<meta property="og:title" content="Nebula Phone X | SmartTech" />', false)
            // social sites can't render SVG, so the first photo is used
            ->assertSee('<meta property="og:image" content="' . asset('images/nebula.jpg') . '" />', false);
    }

    public function test_unknown_product_url_suggests_similar_phones()
    {
        Smartphone::factory()->create(['name' => 'Nebula Phone X']);

        $this->get('/smartphones/nebula-phone')->assertNotFound()->assertSee('Nebula Phone X');
    }
}
