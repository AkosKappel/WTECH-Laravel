<?php

namespace Tests\Feature\Shop;

use App\Models\Image;
use App\Models\Smartphone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_lists_phones_with_the_shop_filters()
    {
        Smartphone::factory()->has(Image::factory())->create(['name' => 'Nebula Phone X', 'price' => 499.9]);
        Smartphone::factory()->create(['name' => 'Other Phone', 'quantity' => 0]);

        $this->get('/api/smartphones?stock=in')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Nebula Phone X')
            ->assertJsonPath('data.0.price', 499.9)
            ->assertJsonPath('data.0.in_stock', true)
            ->assertJsonPath('meta.total', 1);
    }

    public function test_one_phone_and_json_errors()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X']);

        $this->get('/api/smartphones/' . $phone->id)
            ->assertOk()
            ->assertJsonPath('data.url', route('details', $phone));

        // no Accept header, still JSON
        $this->get('/api/smartphones/999999')->assertNotFound()->assertHeader('Content-Type', 'application/json');
    }

    public function test_api_sets_no_cookies()
    {
        $this->get('/api/smartphones')->assertOk()->assertCookieMissing('locale')->assertHeaderMissing('Set-Cookie');
    }
}
