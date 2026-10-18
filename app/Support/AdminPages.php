<?php

namespace App\Support;

/**
 * The admin pages for the real admin only (demo admins see just the products), shared by the
 * admin tabs and the command palette.
 */
class AdminPages
{
    /**
     * @return array<string, array{0: string, 1: string[]}> route name => [label, route patterns that mark it current]
     */
    public static function all()
    {
        return [
            'admin.orders' => [__('Orders'), ['admin.orders']],
            'admin.codes' => [__('Discount codes'), ['admin.codes', 'admin.codes.*']],
            'admin.stats' => [__('Visitors'), ['admin.stats']],
            'admin.translations' => [__('Translations'), ['admin.translations']],
            'admin.maintenance' => [__('Maintenance'), ['admin.maintenance']],
        ];
    }
}
