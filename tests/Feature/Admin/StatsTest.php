<?php

namespace Tests\Feature\Admin;

use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StatsTest extends TestCase
{
    use RefreshDatabase;

    private const BROWSER = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Version/17.0 Mobile Safari/604.1';

    public function test_page_views_are_counted_without_bots_admins_or_ip_addresses()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X']);

        $this->withHeaders(['User-Agent' => self::BROWSER, 'Referer' => 'https://www.linkedin.com/feed/'])->get(route('details', $phone))->assertOk();
        $this->withHeaders(['User-Agent' => 'Googlebot/2.1'])->get('/about');
        $this->actingAs(User::factory()->create(['role' => 'admin']))->withHeaders(['User-Agent' => self::BROWSER])->get('/about');

        $this->assertSame(1, DB::table('page_views')->count());
        $view = DB::table('page_views')->first();
        $this->assertSame($phone->id, (int) $view->smartphone_id);
        $this->assertSame('www.linkedin.com', $view->referrer_host);
        $this->assertSame('mobile', $view->device);
        $this->assertSame('Safari', $view->browser);
        $this->assertStringNotContainsString('127.0.0.1', json_encode($view));
    }

    public function test_admins_see_the_statistics()
    {
        $phone = Smartphone::factory()->create(['name' => 'Nebula Phone X']);
        $this->withHeaders(['User-Agent' => self::BROWSER])->get(route('details', $phone));

        $this->actingAs(User::factory()->create(['role' => 'admin']))->get('/admin/stats')
            ->assertOk()->assertSee('Nebula Phone X')->assertSee('1 visitor');
        $this->actingAs(User::factory()->create())->get('/admin/stats')->assertForbidden();
    }
}
