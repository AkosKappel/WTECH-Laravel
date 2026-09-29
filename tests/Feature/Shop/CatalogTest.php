<?php

namespace Tests\Feature\Shop;

use App\Models\Smartphone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_recommended_phones()
    {
        // the homepage shows inRandomOrder()->take(3): exactly 3 phones make this deterministic
        $phones = Smartphone::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertOk();
        foreach ($phones as $phone) {
            $response->assertSee($phone->name);
        }
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

    public function test_unknown_product_url_suggests_similar_phones()
    {
        Smartphone::factory()->create(['name' => 'Nebula Phone X']);

        $this->get('/smartphones/nebula-phone')->assertNotFound()->assertSee('Nebula Phone X');
    }
}
