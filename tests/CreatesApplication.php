<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use RuntimeException;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // RefreshDatabase wipes the database, so never let the tests touch a real one
        // (e.g. when the config is cached and phpunit.xml's DB_DATABASE is ignored)
        $database = $app['config']->get('database.connections.' . $app['config']->get('database.default') . '.database');
        if (!str_ends_with($database, '_testing')) {
            throw new RuntimeException("Refusing to run the tests against the database '{$database}', only one ending in _testing.");
        }

        return $app;
    }
}
