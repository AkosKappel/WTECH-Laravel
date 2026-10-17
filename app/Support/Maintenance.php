<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Planned maintenance: a message and time window that the shop announces in a banner beforehand
 * and shows on the 503 page while it is down. The plan lives in storage/app, so the nightly demo
 * reset (which empties the database) keeps it. Turning maintenance on returns a secret; the
 * admin who did it gets the matching bypass cookie and can keep using the shop.
 */
class Maintenance
{
    /** How long before the start the banner appears. */
    const NOTICE_HOURS = 48;

    private static function path()
    {
        return storage_path('app/maintenance.json');
    }

    /**
     * @return array{message: ?string, starts_at: ?Carbon, ends_at: ?Carbon}|null
     */
    public static function plan()
    {
        $data = File::exists(self::path()) ? json_decode(File::get(self::path()), true) : null;
        if (!is_array($data)) {
            return null;
        }

        return [
            'message' => $data['message'] ?? null,
            'starts_at' => isset($data['starts_at']) ? Carbon::parse($data['starts_at']) : null,
            'ends_at' => isset($data['ends_at']) ? Carbon::parse($data['ends_at']) : null,
        ];
    }

    public static function savePlan(?string $message, ?Carbon $startsAt, ?Carbon $endsAt)
    {
        File::ensureDirectoryExists(dirname(self::path()));
        File::put(self::path(), json_encode([
            'message' => $message ?: null,
            'starts_at' => $startsAt?->toIso8601String(),
            'ends_at' => $endsAt?->toIso8601String(),
        ]));
    }

    public static function clearPlan()
    {
        File::delete(self::path());
    }

    /**
     * The plan to announce in the banner: one that starts within the next NOTICE_HOURS.
     */
    public static function upcoming()
    {
        $plan = self::plan();

        return $plan && $plan['starts_at'] && $plan['starts_at']->isFuture()
            && $plan['starts_at']->lte(now()->addHours(self::NOTICE_HOURS)) ? $plan : null;
    }

    public static function isDown()
    {
        return app()->maintenanceMode()->active();
    }

    /**
     * Take the shop down; visitors see the 503 page. Returns the bypass secret.
     */
    public static function start()
    {
        $secret = Str::random(32);
        $endsAt = self::plan()['ends_at'] ?? null;
        $retry = $endsAt && $endsAt->isFuture() ? (int) now()->diffInSeconds($endsAt) : 60;

        Artisan::call('down', ['--retry' => max(60, $retry), '--secret' => $secret]);

        return $secret;
    }

    public static function stop()
    {
        Artisan::call('up');
        self::clearPlan();
    }
}
