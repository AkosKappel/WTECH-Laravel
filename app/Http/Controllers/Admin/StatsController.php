<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Smartphone;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Visitor statistics from the page_views table: the last 30 days.
 */
class StatsController extends Controller
{
    const DAYS = 30;

    public function index()
    {
        $tz = config('demo.reset.timezone');
        $since = now($tz)->startOfDay()->subDays(self::DAYS - 1);
        $views = DB::table('page_views')->where('created_at', '>=', $since->clone()->utc());

        $perDay = (clone $views)
            ->selectRaw("date(created_at at time zone 'UTC' at time zone ?) as day, count(*) as views, count(distinct visitor) as visitors", [$tz])
            ->groupBy('day')->get()->keyBy('day');
        // every day, also the ones without visits
        $days = collect(range(0, self::DAYS - 1))->map(function ($offset) use ($since, $perDay) {
            $day = $since->clone()->addDays($offset);
            $row = $perDay->get($day->toDateString());

            return ['date' => $day, 'views' => (int) ($row->views ?? 0), 'visitors' => (int) ($row->visitors ?? 0)];
        });

        $top = fn ($column, $limit = 8) => (clone $views)->whereNotNull($column)
            ->selectRaw("$column as label, count(*) as count")->groupBy($column)->orderByDesc('count')->limit($limit)->get();
        $products = $top('smartphone_id');
        $names = Smartphone::withoutGlobalScopes()->whereIn('id', $products->pluck('label'))->pluck('name', 'id');

        return view('layout.admin.stats', [
            'days' => $days,
            'totals' => ['views' => $days->sum('views'), 'visitors' => $days->sum('visitors'), 'today' => $days->last()['visitors']],
            'pages' => $top('path'),
            'products' => $products->map(fn ($row) => (object) ['label' => $names[$row->label] ?? '#' . $row->label, 'count' => $row->count, 'id' => $row->label]),
            'referrers' => $top('referrer_host'),
            'devices' => $top('device', 3),
            'browsers' => $top('browser', 6),
        ]);
    }
}
