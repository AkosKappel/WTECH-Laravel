<?php

namespace Tests\Feature\Shop;

use App\Models\Review;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewsWishlistCompareTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_review_a_phone_once_and_see_the_average()
    {
        $phone = Smartphone::factory()->create();
        $customer = User::factory()->create(['first_name' => 'Jana']);

        $this->post(route('reviews.store', $phone), ['rating' => 5])->assertRedirect(route('login'));
        $this->actingAs($customer)->post(route('reviews.store', $phone), ['rating' => 6])->assertSessionHasErrors('rating');
        $this->actingAs($customer)->post(route('reviews.store', $phone), ['rating' => 2, 'body' => 'Meh.']);
        $this->actingAs($customer)->post(route('reviews.store', $phone), ['rating' => 4, 'body' => 'Better after an update.']);
        $this->actingAs(User::factory()->create())->post(route('reviews.store', $phone), ['rating' => 5]);

        $this->assertSame(2, Review::count());
        $this->get(route('details', $phone))
            ->assertSee('Better after an update.')
            ->assertSee('4.5 out of 5 stars')
            ->assertSee('"reviewCount":2', false);
    }

    public function test_only_the_author_or_an_admin_deletes_a_review()
    {
        $review = Review::create(['smartphone_id' => Smartphone::factory()->create()->id, 'user_id' => User::factory()->create()->id, 'rating' => 3]);

        $this->actingAs(User::factory()->create())->delete(route('reviews.destroy', $review))->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'admin']))->delete(route('reviews.destroy', $review))->assertRedirect();
        $this->assertModelMissing($review);
    }

    public function test_wishlist_toggles_and_lists_phones()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X']);
        $customer = User::factory()->create();

        $this->actingAs($customer)->post(route('wishlist.toggle', $phone));
        $this->actingAs($customer)->get('/wishlist')->assertSee('Nebula Phone X');
        $this->actingAs($customer)->post(route('wishlist.toggle', $phone));
        $this->actingAs($customer)->get('/wishlist')->assertSee('Your wishlist is empty.');
    }

    public function test_compare_holds_up_to_four_phones()
    {
        $phones = Smartphone::factory()->count(5)->create();

        foreach ($phones->take(4) as $phone) {
            $this->post(route('compare.toggle', $phone))->assertSessionHasNoErrors();
        }
        $this->post(route('compare.toggle', $phones[4]))->assertSessionHasErrors('compare');

        $this->get('/compare')->assertOk()->assertSee($phones[0]->name)->assertDontSee($phones[4]->name);
        $this->get('/')->assertSee('Compare (4)');
    }

    public function test_compare_shows_ram_in_gigabytes()
    {
        $phone = Smartphone::factory()->create(['ram' => 8192]);

        $this->post(route('compare.toggle', $phone));

        $this->get('/compare')->assertSee('8 GB')->assertDontSee('8192');
    }
}
