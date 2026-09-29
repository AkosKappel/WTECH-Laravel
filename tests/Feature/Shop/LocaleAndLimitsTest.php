<?php

namespace Tests\Feature\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleAndLimitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_switching_language_sets_a_cookie()
    {
        $this->from('/about')->post('/locale/de')->assertRedirect('/about')->assertCookie('locale', 'de');
    }

    public function test_unknown_language_is_not_found()
    {
        $this->post('/locale/xx')->assertNotFound();
    }

    public function test_pages_are_translated_for_the_chosen_language()
    {
        $this->withCookie('locale', 'de')->get('/about')->assertOk()->assertSee('SmartTech entstand als Semesterprojekt');
    }

    public function test_sign_up_forms_are_rate_limited()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/forgot-password', ['email' => "nobody{$i}@example.invalid"])->assertStatus(302);
        }

        $this->post('/forgot-password', ['email' => 'nobody6@example.invalid'])->assertStatus(429);
    }
}
