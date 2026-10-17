<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo reviews, so product pages and cards show ratings. The reviewers have no password and
 * an address on a reserved domain, so nobody can sign in as them or take them over by ordering.
 */
class ReviewSeeder extends Seeder
{
    const REVIEWERS = ['Jana', 'Lukas', 'Marta', 'Peter', 'Eva', 'Tomas', 'Anna', 'Michal'];

    /** Phone name => [reviewer index, rating, text] */
    const REVIEWS = [
        'Apple iPhone 15 Pro 256GB' => [
            [0, 5, 'Light, fast and the camera is excellent even at night. The titanium frame feels great in the hand.'],
            [3, 4, 'Superb phone, but the battery only just lasts a full day when I use the camera a lot.'],
            [6, 5, 'The Action button is more useful than I expected. Switched from Android and do not regret it.'],
        ],
        'Samsung Galaxy S24 8GB/256GB' => [
            [1, 5, 'Compact, bright display and seven years of updates. Exactly what I wanted.'],
            [4, 4, 'Great screen and cameras. Charging could be faster.'],
            [7, 5, 'Bought it on sale and it was worth every euro.'],
        ],
        'Google Pixel 8a 8GB/128GB' => [
            [2, 5, 'Best value phone I have owned. Photos look like they came from a much pricier camera.'],
            [5, 4, 'Clean Android and quick updates. The bezels are a bit thick, but I stopped noticing after a day.'],
        ],
        'Google Pixel 8 8GB/128GB' => [
            [3, 5, 'Call screening alone saves me time every week. Lovely size, too.'],
            [6, 3, 'Good phone, but it gets warm when gaming.'],
        ],
        'Xiaomi Redmi Note 13 Pro 8GB/256GB' => [
            [0, 4, 'Amazing display and battery for the price. Too many preinstalled apps, though.'],
            [4, 5, 'Two days of battery and it charges in under an hour. Very happy.'],
        ],
        'OnePlus 12 12GB/256GB' => [
            [1, 5, 'Ridiculously fast charging and smooth as butter. The best phone I have had.'],
            [7, 4, 'Fantastic performance; the camera is good but not the best in low light.'],
        ],
        'Nothing Phone (2) 12GB/256GB' => [
            [2, 4, 'The light-up back is fun and the software is clean. Turns heads in cafés.'],
            [5, 5, 'Feels premium, runs smoothly and the interface is wonderfully minimal.'],
        ],
        'Fairphone 5 8GB/256GB' => [
            [6, 5, 'Replaced the battery myself in two minutes. A phone I can keep for years.'],
            [3, 3, 'I love the idea and the support, but the camera is only average.'],
        ],
        'Motorola Edge 50 Pro 12GB/512GB' => [
            [4, 4, 'The curved screen looks beautiful and the vegan leather back is not slippery.'],
        ],
        'Samsung Galaxy A55 5G 8GB/128GB' => [
            [0, 4, 'Solid mid-range phone with a metal frame. Does everything I need.'],
            [7, 4, 'Good battery and a nice screen. A little heavy.'],
        ],
        'Sony Xperia 1 VI 12GB/256GB' => [
            [5, 5, 'Headphone jack, microSD slot and a great camera. Sony still makes phones for enthusiasts.'],
        ],
        'Nokia 3210 4G (2024)' => [
            [1, 4, 'Bought it for a digital detox weekend and ended up keeping it as my second phone.'],
            [2, 2, 'Fun nostalgia, but typing messages on the keypad is slow.'],
        ],
        'Honor Magic6 Pro 12GB/512GB' => [
            [6, 5, 'Battery for days and a telephoto camera that is really sharp.'],
        ],
    ];

    public function run()
    {
        $reviewers = collect(self::REVIEWERS)->map(fn ($name, $index) => User::create([
            'first_name' => $name,
            'email' => 'reviewer-' . ($index + 1) . '@reviews.demo.invalid',
        ]));

        $daysAgo = 2;
        foreach (self::REVIEWS as $phoneName => $reviews) {
            $phone = Smartphone::firstWhere('name', $phoneName);
            if (!$phone) {
                continue;
            }
            foreach ($reviews as [$reviewer, $rating, $body]) {
                $review = new Review(['smartphone_id' => $phone->id, 'user_id' => $reviewers[$reviewer]->id, 'rating' => $rating, 'body' => $body]);
                $review->created_at = $review->updated_at = now()->subDays($daysAgo)->setTime(9 + $daysAgo % 10, ($daysAgo * 7) % 60);
                $review->save();
                $daysAgo += 2;
            }
        }
    }
}
