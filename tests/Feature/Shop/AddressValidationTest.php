<?php

namespace Tests\Feature\Shop;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressValidationTest extends TestCase
{
    use RefreshDatabase;

    private function address(array $overrides = [])
    {
        return array_merge([
            'first_name' => 'Anna-Mária', 'last_name' => "O'Neill", 'phone_number' => '+421 900 123 456',
            'email' => 'anna@example.com', 'street' => 'Hlavná', 'descriptive_number' => '1234/56A',
            'city' => 'Banská Bystrica', 'country' => 'Slovakia',
        ], $overrides);
    }

    public function test_valid_checkout_details_pass()
    {
        $this->put('/address', $this->address())->assertSessionHasNoErrors()->assertRedirect(route('delivery'));
    }

    public function test_checkout_rejects_bad_phone_numbers_names_and_countries()
    {
        foreach ([
            ['phone_number' => '12345'],          // too few digits
            ['phone_number' => '+421 900 12a 456'], // a letter
            ['phone_number' => '1234567890123456'], // 16 digits
            ['first_name' => 'R2D2'],
            ['street' => '42'],
            ['descriptive_number' => 'A12'],
            ['country' => 'Atlantis'],
        ] as $bad) {
            $field = array_key_first($bad);
            $this->put('/address', $this->address($bad))->assertSessionHasErrors($field);
        }
    }

    public function test_profile_fields_are_optional_but_validated_and_e_mails_unique()
    {
        $user = User::factory()->create();
        User::factory()->create(['email' => 'taken@example.com']);

        $this->actingAs($user)->put('/profile', ['email' => $user->email])->assertSessionHasNoErrors();
        $this->actingAs($user)->put('/profile', ['email' => $user->email, 'phone_number' => 'call me'])->assertSessionHasErrors('phone_number');
        $this->actingAs($user)->put('/profile', ['email' => 'taken@example.com'])->assertSessionHasErrors('email');
        $this->actingAs($user)->put('/profile', ['email' => $user->email, 'country' => 'Germany'])->assertSessionHasNoErrors();
        $this->assertSame('Germany', $user->fresh()->country);
    }

    public function test_the_country_field_lists_translated_countries()
    {
        $this->get('/de/address')->assertSee('<option value="Germany" >Deutschland</option>', false);
    }
}
