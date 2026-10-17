<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // visitor statistics are kept for 90 days
        $schedule->call(fn () => \Illuminate\Support\Facades\DB::table('page_views')->where('created_at', '<', now()->subDays(90))->delete())
            ->daily()->name('prune-page-views');

        $schedule->command('demo:reset', ['--force'])
            ->dailyAt(config('demo.reset.time'))
            ->timezone(config('demo.reset.timezone'))
            ->when(function () {
                return config('demo.reset.enabled');
            })
            ->appendOutputTo(storage_path('logs/demo-reset.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
