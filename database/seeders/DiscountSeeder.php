<?php

namespace Database\Seeders;

use App\Models\DiscountCode;
use App\Models\Smartphone;
use Illuminate\Database\Seeder;

/**
 * Demo discounts: a few phones on sale (one of them ending soon) and the public code DEMO10,
 * which the cart page mentions. The nightly reset restores them.
 */
class DiscountSeeder extends Seeder
{
    public function run()
    {
        $sales = [
            'Samsung Galaxy S24 8GB/256GB' => [0.80, null],
            'Google Pixel 8a 8GB/128GB' => [0.85, null],
            'Xiaomi Redmi Note 13 Pro 8GB/256GB' => [0.75, now()->addDays(7)],
            'Motorola Edge 50 Pro 12GB/512GB' => [0.70, null],
        ];
        foreach ($sales as $name => [$factor, $endsAt]) {
            $phone = Smartphone::firstWhere('name', $name);
            // whole euros minus a cent, like a real shop
            $phone?->update(['sale_price' => floor($phone->price * $factor) - 0.01, 'sale_ends_at' => $endsAt]);
        }

        DiscountCode::create(['code' => 'DEMO10', 'type' => 'percent', 'value' => 10]);
        DiscountCode::create(['code' => 'SAVE50', 'type' => 'fixed', 'value' => 50, 'min_order' => 500]);
    }
}
