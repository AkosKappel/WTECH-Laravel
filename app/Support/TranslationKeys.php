<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

/**
 * The UI strings of the shop: every literal passed to __() or trans_choice() in views, app code
 * and routes, plus the ones that reach __() through variables. Used by `php artisan lang:missing`
 * and the admin translation manager.
 */
class TranslationKeys
{
    /**
     * Strings that reach __() through variables, so they can't be found by scanning.
     */
    const DYNAMIC = [
        'red', 'green', 'blue', 'yellow', 'purple', 'pink', 'white', 'gray', 'black',
        'Courier Delivery', 'Personal Pickup', 'Post Office Delivery', 'Parcel Locker',
        'Cash on Delivery', 'Bank Transfer', 'Credit Card', 'Apple Pay', 'Google Pay',
        'Free Shipping', 'Enjoy free delivery on all orders', 'Best Price Guarantee',
        "We match any competitor's price", '2-Year Premium Warranty', 'Extended protection for your device',
        // order statuses (Order::statusLabel) and devices (visitor statistics)
        'New', 'Paid', 'Shipped', 'Delivered', 'Cancelled', 'Mobile', 'Desktop', 'Tablet',
    ];

    /**
     * Keys and where they are used, e.g. ['Cart' => ['resources/views/…/header.blade.php:42']].
     * Keys of PHP translation files (e.g. auth.failed) are skipped.
     *
     * @return array<string, string[]>
     */
    public static function used()
    {
        $keys = array_fill_keys(self::DYNAMIC, []);
        foreach ([resource_path('views'), app_path(), base_path('routes')] as $directory) {
            foreach (File::allFiles($directory) as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }
                $contents = $file->getContents();
                preg_match_all('/(?:__|trans_choice)\(\s*(?:\'((?:[^\'\\\\]|\\\\.)*)\'|"((?:[^"\\\\$]|\\\\.)*)")/', $contents, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
                foreach ($matches as $match) {
                    $key = isset($match[2]) && $match[2][0] !== '' ? stripslashes($match[2][0]) : str_replace("\\'", "'", $match[1][0]);
                    if ($key === '' || preg_match('/^[a-z_]+\.[a-z_.]+$/', $key)) {
                        continue;
                    }
                    $line = substr_count($contents, "\n", 0, $match[0][1]) + 1;
                    $keys[$key][] = str_replace(base_path() . '/', '', $file->getPathname()) . ':' . $line;
                }
            }
        }
        ksort($keys);

        return $keys;
    }
}
