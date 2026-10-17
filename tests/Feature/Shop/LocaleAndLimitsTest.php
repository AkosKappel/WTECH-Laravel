<?php

namespace Tests\Feature\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleAndLimitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_switching_language_sets_a_cookie()
    {
        $this->from('/about')->post('/locale/de')->assertRedirect(url('/de/about'))->assertCookie('locale', 'de');
        $this->from(url('/de/about'))->post('/de/locale/en')->assertRedirect(url('/about'));
    }

    public function test_unknown_language_is_not_found()
    {
        $this->post('/locale/xx')->assertNotFound();
    }

    public function test_pages_are_translated_for_the_chosen_language()
    {
        $this->get('/de/about')->assertOk()->assertSee('SmartTech entstand als Semesterprojekt');
        $this->get('/about')->assertOk()->assertDontSee('SmartTech entstand als Semesterprojekt');
    }

    public function test_a_chosen_or_preferred_language_redirects_to_its_urls()
    {
        $this->withCookie('locale', 'de')->get('/about')->assertRedirect(url('/de/about'));
    }

    public function test_the_browser_language_redirects_first_time_visitors()
    {
        $this->withHeader('Accept-Language', 'sk-SK,sk;q=0.9')->get('/smartphones?q=pixel')->assertRedirect(url('/sk/smartphones?q=pixel'));
    }

    public function test_an_explicit_choice_of_english_wins_over_the_browser()
    {
        $this->withCookie('locale', 'en')->withHeader('Accept-Language', 'de')->get('/about')->assertOk();
    }

    public function test_pages_link_within_their_language_and_name_the_alternatives()
    {
        $this->get('/de/about')
            ->assertSee('href="' . url('/de/smartphones') . '"', false)
            ->assertSee('<link rel="alternate" hreflang="sk" href="' . url('/sk/about') . '" />', false)
            ->assertSee('<link rel="alternate" hreflang="x-default" href="' . url('/about') . '" />', false)
            ->assertSee('<link rel="canonical" href="' . url('/de/about') . '" />', false);
    }

    public function test_prices_follow_the_language()
    {
        $prices = [];
        foreach (['en', 'de', 'sk'] as $locale) {
            app()->setLocale($locale);
            $prices[$locale] = formattedPrice(1234.5);
        }

        $this->assertSame(['en' => '€1,234.50', 'de' => '1.234,50 €', 'sk' => '1 234,50 €'], $prices);
    }

    public function test_sign_up_forms_are_rate_limited()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/forgot-password', ['email' => "nobody{$i}@example.invalid"])->assertStatus(302);
        }

        $this->post('/forgot-password', ['email' => 'nobody6@example.invalid'])->assertStatus(429);
    }
}
