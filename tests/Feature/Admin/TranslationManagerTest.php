<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TranslationManagerTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_an_edit_overrides_the_language_file_and_can_be_exported()
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put('/admin/translations', ['key' => 'Contact', 'values' => ['de' => 'Schreiben Sie uns', 'sk' => '']])
            ->assertSessionHasNoErrors();

        app()->setLocale('de');
        $this->assertSame('Schreiben Sie uns', __('Contact'));
        $this->withCookie('locale', 'de')->get('/contact')->assertSee('Schreiben Sie uns');

        $this->actingAs($admin)->get('/admin/translations/de.json')
            ->assertOk()->assertHeader('Content-Disposition', 'attachment; filename="de.json"')
            ->assertSee('"Contact": "Schreiben Sie uns"', false);

        // back to the file text: the override goes away
        $file = json_decode(file_get_contents(resource_path('lang/de.json')), true)['Contact'];
        $this->actingAs($admin)->put('/admin/translations', ['key' => 'Contact', 'values' => ['de' => $file]]);
        $this->assertDatabaseCount('translations', 0);
    }

    public function test_the_list_warns_about_missing_placeholders()
    {
        $admin = $this->admin();
        $this->actingAs($admin)->put('/admin/translations', ['key' => 'Only :count left', 'values' => ['de' => 'Nur wenige übrig']]);

        $this->actingAs($admin)->get('/admin/translations?filter=warnings')
            ->assertOk()->assertSee('Only :count left')->assertSee('Missing placeholder :count');
    }

    public function test_a_json_file_is_imported_as_edits()
    {
        $file = UploadedFile::fake()->createWithContent('de.json', json_encode(['Contact' => 'Kontaktieren', 'Not a real key' => 'x']));

        $this->actingAs($this->admin())->post('/admin/translations/import', ['locale' => 'de', 'file' => $file])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('translations', ['locale' => 'de', 'key' => 'Contact', 'value' => 'Kontaktieren']);
        $this->assertDatabaseCount('translations', 1);
    }

    public function test_only_admins_manage_translations()
    {
        $this->actingAs(User::factory()->create())->get('/admin/translations')->assertForbidden();
    }
}
