<?php

namespace App\Console\Commands;

use App\Support\Maintenance;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

/**
 * Maintenance from the command line, the same as the admin page:
 *   php artisan shop:maintenance plan --from="2026-10-20 22:00" --until="2026-10-20 22:30" --message="New payment options"
 *   php artisan shop:maintenance on      (prints the bypass link)
 *   php artisan shop:maintenance off
 */
class ShopMaintenance extends Command
{
    protected $signature = 'shop:maintenance {action : plan, on, off or status} {--from= : start, in the shop\'s time zone} {--until= : expected end} {--message= : shown to visitors}';

    protected $description = 'Plan, start or end maintenance with a message and an expected end';

    public function handle()
    {
        $time = fn ($value) => $value ? Carbon::parse($value, config('demo.reset.timezone')) : null;

        switch ($this->argument('action')) {
            case 'plan':
                Maintenance::savePlan($this->option('message'), $time($this->option('from')), $time($this->option('until')));
                $this->info('Maintenance planned; the banner shows up to ' . Maintenance::NOTICE_HOURS . ' hours before the start.');
                return 0;
            case 'on':
                if ($this->option('message') || $this->option('until')) {
                    Maintenance::savePlan($this->option('message'), now(), $time($this->option('until')));
                }
                $secret = Maintenance::start();
                $this->info('The shop is down. Bypass: ' . url($secret));
                return 0;
            case 'off':
                Maintenance::stop();
                $this->info('The shop is up again.');
                return 0;
            case 'status':
                $plan = Maintenance::plan();
                $this->line((Maintenance::isDown() ? 'Down' : 'Up') . ($plan ? ', plan: ' . json_encode($plan) : ', no plan'));
                return 0;
        }

        $this->error('Unknown action; use plan, on, off or status.');
        return 1;
    }
}
