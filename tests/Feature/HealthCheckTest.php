<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_reports_ok_without_starting_a_session()
    {
        $this->get('/up')
            ->assertOk()
            ->assertExactJson(['status' => 'ok'])
            ->assertCookieMissing(config('session.cookie'));
    }

    public function test_reports_unavailable_when_the_database_is_down()
    {
        // nothing listens on port 1, so connecting fails at once
        config([
            'database.connections.broken' => ['port' => 1] + config('database.connections.pgsql'),
            'database.default' => 'broken',
        ]);

        $this->get('/up')
            ->assertStatus(503)
            ->assertExactJson(['status' => 'error']);
    }
}
