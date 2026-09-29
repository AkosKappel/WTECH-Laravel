<?php

namespace Tests\Feature\Admin;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Image;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminProductsTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        // uploads land in the real public/uploads/products: remove the test's files
        try {
            foreach (Image::all() as $image) {
                $image->deleteFile();
            }
        } finally {
            parent::tearDown();
        }
    }

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function product(array $overrides = [])
    {
        return array_merge([
            'name' => 'Admin Test Phone',
            'price' => 499,
            'quantity' => 7,
        ], $overrides);
    }

    public function test_guests_are_sent_to_the_login()
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_customers_are_forbidden()
    {
        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
    }

    public function test_admin_can_create_a_phone_with_an_image()
    {
        $brand = Brand::factory()->create();
        $color = Color::factory()->create();

        $this->actingAs($this->admin())
            ->post('/smartphones/add', $this->product([
                'brand' => $brand->name,
                'color' => $color->name_en,
                'images' => [UploadedFile::fake()->image('phone.jpg', 600, 600)],
            ]))
            ->assertRedirect(route('admin'));

        $phone = Smartphone::firstWhere('name', 'Admin Test Phone');
        $this->assertEquals($brand->id, $phone->brand_id);
        $this->assertEquals($color->id, $phone->color_id);
        $image = $phone->images()->first();
        $this->assertStringStartsWith('/uploads/products/', $image->source);
        $this->assertFileExists(public_path(ltrim($image->source, '/')));
    }

    public function test_non_image_uploads_are_rejected()
    {
        $this->actingAs($this->admin())
            ->post('/smartphones/add', $this->product([
                'images' => [UploadedFile::fake()->create('shell.php', 1, 'application/x-php')],
            ]))
            ->assertSessionHasErrors('images.0');

        $this->assertEquals(0, Smartphone::count());
    }

    public function test_admin_can_update_a_phone()
    {
        $phone = Smartphone::factory()->create();

        $this->actingAs($this->admin())
            ->put(route('smartphones.update', $phone), $this->product(['price' => 555]))
            ->assertRedirect(route('admin'));

        $this->assertEquals(555, $phone->fresh()->price);
        $this->assertEquals('Admin Test Phone', $phone->fresh()->name);
    }

    public function test_admin_can_delete_a_phone()
    {
        $phone = Smartphone::factory()->create();

        $this->actingAs($this->admin())->from('/admin')->delete(route('smartphones.delete', $phone));

        $this->assertDatabaseMissing('smartphones', ['id' => $phone->id]);
    }

    private function createPhoneWithUpload()
    {
        $this->actingAs($this->admin())
            ->post('/smartphones/add', $this->product([
                'brand' => Brand::factory()->create()->name,
                'color' => Color::factory()->create()->name_en,
                'images' => [UploadedFile::fake()->image('phone.jpg', 600, 600)],
            ]))
            ->assertRedirect(route('admin'));

        $phone = Smartphone::firstWhere('name', 'Admin Test Phone');
        $image = $phone->images()->first();
        $this->assertFileExists(public_path(ltrim($image->source, '/')));

        return [$phone, $image];
    }

    public function test_edit_form_preselects_brand_and_color_and_lists_images()
    {
        $phone = Smartphone::factory()->create();
        Image::factory()->create(['smartphone_id' => $phone->id]);

        $this->actingAs($this->admin())
            ->get(route('smartphones.edit', $phone))
            ->assertOk()
            ->assertSee('name="brand" value="' . e($phone->brand->name) . '" id="' . e($phone->brand->name) . '" class="form-checkbox h-4 w-4" checked', false)
            ->assertSee('name="color" value="' . e($phone->color->name_en) . '" id="' . e($phone->color->name_en) . '" class="form-checkbox h-4 w-4" checked', false)
            ->assertSee('<input type="checkbox" name="images/no_img_available.jpg"', false);
    }

    public function test_admin_can_remove_an_uploaded_image_on_update()
    {
        [$phone, $image] = $this->createPhoneWithUpload();
        $path = public_path(ltrim($image->source, '/'));

        // PHP turns "." into "_" in real form field names; the test client does not
        $this->put(route('smartphones.update', $phone), $this->product([
            str_replace('.', '_', $image->source) => $image->source,
        ]))->assertRedirect(route('admin'));

        $this->assertDatabaseMissing('images', ['id' => $image->id]);
        $this->assertFileDoesNotExist($path);
    }

    public function test_deleting_a_phone_removes_its_uploaded_files()
    {
        [$phone, $image] = $this->createPhoneWithUpload();
        $path = public_path(ltrim($image->source, '/'));

        $this->from('/admin')->delete(route('smartphones.delete', $phone))->assertRedirect('/admin');

        $this->assertDatabaseMissing('smartphones', ['id' => $phone->id]);
        $this->assertFileDoesNotExist($path);
    }

    public function test_admin_can_upload_a_png_image()
    {
        $this->actingAs($this->admin())
            ->post('/smartphones/add', $this->product([
                'images' => [UploadedFile::fake()->image('phone.png', 300, 300)],
            ]))
            ->assertRedirect(route('admin'));

        $image = Smartphone::firstWhere('name', 'Admin Test Phone')->images()->first();
        $this->assertStringEndsWith('.png', $image->source);
        $path = public_path(ltrim($image->source, '/'));
        $this->assertFileExists($path);
        $this->assertSame('image/png', mime_content_type($path));
    }

    public function test_admin_can_upload_a_webp_image()
    {
        $this->actingAs($this->admin())
            ->post('/smartphones/add', $this->product([
                'images' => [UploadedFile::fake()->image('phone.webp', 300, 300)],
            ]))
            ->assertRedirect(route('admin'));

        $image = Smartphone::firstWhere('name', 'Admin Test Phone')->images()->first();
        $this->assertStringEndsWith('.webp', $image->source);
        $path = public_path(ltrim($image->source, '/'));
        $this->assertFileExists($path);
        $this->assertSame('image/webp', mime_content_type($path));
    }
}
