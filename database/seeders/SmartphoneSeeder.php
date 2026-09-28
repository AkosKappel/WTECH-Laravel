<?php

namespace Database\Seeders;

use App\Models\Smartphone;
use Illuminate\Database\Seeder;

class SmartphoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy A52 6GB/128GB',
            'price' => 189.99,
            'quantity' => 10,
            'brand_id' => 1,
            'color_id' => 1,
            'description' => 'An elegant smartphone with a large, eye-friendly display that stays smooth and readable in any conditions. Four camera lenses capture ultra-wide shots, steady and sharp images, blurred backgrounds and macro photos, with stabilised video and high-resolution selfies. The phone is water resistant, so you can even take it for a swim. The large battery lasts all weekend and fast charging tops it up without delay. Game Booster and two quality speakers make gaming more fun, and Samsung Knox with a fingerprint reader keeps the Galaxy A52 secure.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.5,
            'resolution' => '2400 x 1080',
            'height' => 159.9,
            'width' => 75.1,
            'thickness' => 8.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi Note 10 Pro 6GB/128GB',
            'price' => 299.00,
            'quantity' => 20,
            'brand_id' => 3,
            'color_id' => 2,
            'description' => 'A top-equipped camera for everyone who loves keeping memories in photos and videos. A huge choice of features and modes makes photography more fun: create unusual shots with yourself in them several times, or combine the front and rear cameras in one picture. The long battery life lets you head out without a charger, and the powerful processor keeps up with anything you do. 3D sound means more fun with films and games, all in a smartphone with a timeless design.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.67,
            'resolution' => '2400 x 1080',
            'height' => 164,
            'width' => 76.5,
            'thickness' => 8.1,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 12 128GB',
            'price' => 818.90,
            'quantity' => 30,
            'brand_id' => 7,
            'color_id' => 3,
            'description' => 'The twelfth generation of the popular smartphone will not disappoint. Its powerful processor handles demanding tasks in an instant while staying energy efficient. The almost bezel-less display shows every colour vividly, with individually lit pixels for even better picture quality. 5G support means fast downloads, clear calls and smooth live streams. The dual camera offers plenty of features and effects to perfect every photo and video, and the iPhone 12 is resistant to dust, water and impacts.',
            'ram' => 4096,
            'operating_system' => 'iOS',
            'os_version' => 14,
            'display_size' => 6.1,
            'resolution' => '2532 x 1170',
            'height' => 146.7,
            'width' => 71.5,
            'thickness' => 7.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 11 64GB',
            'price' => 638.00,
            'quantity' => 50,
            'brand_id' => 7,
            'color_id' => 4,
            'description' => 'The highlight is the long-awaited wide and ultra-wide camera system, which captures a scene in all its beauty and offers 2x optical zoom out. Night mode lets you take pictures even in deep darkness, and video goes up to 4K at 60 fps, with slow motion at up to 240 fps in Full HD. All of this is handled by the A13 Bionic chip with an ultra-fast GPU that copes with any game or app. The body features very durable glass and a battery that plays up to 17 hours of video and charges quickly.',
            'ram' => 4096,
            'operating_system' => 'iOS',
            'os_version' => 13,
            'display_size' => 6.1,
            'resolution' => '1792 x 828',
            'height' => 150.9,
            'width' => 75.7,
            'thickness' => 8.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy S20 6GB/128GB Dual SIM',
            'price' => 468.00,
            'quantity' => 100,
            'brand_id' => 1,
            'color_id' => 5,
            'description' => 'This Samsung smartphone has everything you need. The triple camera offers many features and modes for better photos than ever, and the high-resolution front camera takes sharp, realistic selfies. A powerful processor, 6 GB of RAM, LTE and Wi-Fi 6 keep everything running smoothly, and the large storage with memory card support holds more apps, games, films and music than you will need. The Galaxy S20 FE is also water resistant, works well with other devices and comes in several colours.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.5,
            'resolution' => '2400 x 1080',
            'height' => 159.8,
            'width' => 74.5,
            'thickness' => 8.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy S21 5G 8GB/128GB',
            'price' => 705.90,
            'quantity' => 200,
            'brand_id' => 1,
            'color_id' => 6,
            'description' => 'A water-resistant Samsung phone refined from every angle. It has a large, smooth display with eye protection, covered by tough Corning Gorilla Glass. It records stabilised, ultra-smooth 8K video and can turn frames into photos, and it takes clear pictures even in the dark. The battery charges in no time and can even share power with other devices. On top of that, the phone is protected by Knox, supports 5G and connects to your TV and computer.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.2,
            'resolution' => '2400 x 1080',
            'height' => 151.7,
            'width' => 71.2,
            'thickness' => 7.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy A12 4GB/64GB',
            'price' => 178.90,
            'quantity' => 150,
            'brand_id' => 1,
            'color_id' => 7,
            'description' => 'The Samsung Galaxy A12 combines generous features with an elegant, modern design. It offers an octa-core processor, a quad camera with a 48 MP main sensor and a high-capacity battery. Everything looks great on the 6.5-inch Infinity-V display with HD+ resolution. The phone runs Android with plenty of smart features and multi-layered security, and its lovely colours and timeless finish catch the eye.',
            'ram' => 4096,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.5,
            'resolution' => '1600 x 720',
            'height' => 164.0,
            'width' => 75.8,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi 9A 2GB/32GB',
            'price' => 109.99,
            'quantity' => 100,
            'brand_id' => 3,
            'color_id' => 8,
            'description' => 'A simple design with a back that resists fingerprints fits in at a party as well as at a business meeting. The almost bezel-less display with a teardrop notch emits less blue light, so your eyes stay comfortable during long use. The large battery lasts the whole day and is built to last for years. A capable processor, face unlock and an AI camera make the phone more fun and more secure to use.',
            'ram' => 2048,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.53,
            'resolution' => '1600 x 720',
            'height' => 164.9,
            'width' => 77.07,
            'thickness' => 9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi Note 9 Pro 6GB/128GB',
            'price' => 239.00,
            'quantity' => 90,
            'brand_id' => 3,
            'color_id' => 9,
            'description' => 'Four camera lenses capture any moment vividly, and the selfie camera can even record portraits in slow motion. Plenty of filters and modes make it easy to create vlogs and short films, and a built-in app scans and edits documents for work. Long battery life and a powerful processor handle the most demanding apps and games, and a fingerprint reader keeps everything secure.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.67,
            'resolution' => '2340 x 1080',
            'height' => 165.75,
            'width' => 76.68,
            'thickness' => 8.8,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei P30 Lite 4GB/128GB Dual SIM',
            'price' => 209.90,
            'quantity' => 25,
            'brand_id' => 2,
            'color_id' => 1,
            'description' => 'A refined phone with a large display and an elegant design that is still easy to use with one hand. It is fast and powerful enough for demanding games, so there is no stuttering or slow loading. Plenty of storage, fast charging and great graphics make it a pleasure to use. The camera takes photos that rival much more expensive devices, and many other improvements make everyday tasks easier.',
            'ram' => 4096,
            'operating_system' => 'Android',
            'os_version' => 9,
            'display_size' => 6.15,
            'resolution' => '2312 x 1080',
            'height' => 152.9,
            'width' => 72.7,
            'thickness' => 7.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei P Smart 2021 Dual SIM',
            'price' => 199.99,
            'quantity' => 17,
            'brand_id' => 2,
            'color_id' => 2,
            'description' => 'This Huawei smartphone impresses with quality build and modern colours. The elegant look is completed by a large high-resolution display and a fingerprint reader on the side. It offers plenty of storage and an efficient battery with fast charging. The quad camera is ready for anything, with ultra-wide, macro and depth lenses next to a high-resolution main camera.',
            'ram' => 4096,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.67,
            'resolution' => '1400 x 1080',
            'height' => 165.65,
            'width' => 76.88,
            'thickness' => 9.26,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei P40 Lite 6GB/128GB Dual SIM',
            'price' => 219.99,
            'quantity' => 19,
            'brand_id' => 2,
            'color_id' => 3,
            'description' => 'The Huawei P40 Lite will please every fan of mobile technology. It has an advanced quad camera, strong performance and a smart interface, so you get great shots by day and night, smooth operation and enough storage. The understated design suits any style. The high-capacity battery lasts a long day, and fast charging restores the energy surprisingly quickly.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.4,
            'resolution' => '2310 x 1080',
            'height' => 159.2,
            'width' => 76.3,
            'thickness' => 8.7,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Lenovo K10 Note 6/128',
            'price' => 199.00,
            'quantity' => 45,
            'brand_id' => 4,
            'color_id' => 4,
            'description' => 'The Lenovo K10 Note has an elegant, bezel-less body dominated by a large display across the whole front. At its heart is a powerful octa-core processor with 6 GB of RAM for a responsive Android 9 and all your apps and games. There is 128 GB of storage, expandable with a memory card of up to 256 GB, and a fingerprint reader on the back keeps the phone secure.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 9,
            'display_size' => 6.3,
            'resolution' => '2340 x 1080',
            'height' => 156.6,
            'width' => 74.3,
            'thickness' => 7.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia G10',
            'price' => 129.90,
            'quantity' => 22,
            'brand_id' => 5,
            'color_id' => 5,
            'description' => 'The Nokia G10 has a refined Scandinavian design inspired by Nordic colours, for everyone who values practical elegance with modern technology. The 13 + 2 + 2 MP rear camera adds macro and depth lenses to the main one, with portrait and night modes for colourful, sharp photos even in poor light, and the 8 MP front camera takes good selfies. Enjoy it all on the 6.52-inch HD+ IPS LCD touchscreen (1600 × 720), which is great for videos, games and browsing.',
            'ram' => 3072,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.5,
            'resolution' => '1600 x 720',
            'height' => 164.9,
            'width' => 76.0,
            'thickness' => 9.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia 8000 Dual Sim',
            'price' => 75.90,
            'quantity' => 310,
            'brand_id' => 5,
            'color_id' => 6,
            'description' => 'Keep up with modern technology. The Nokia 8000 4G supports fast LTE networks, so you always stay connected. WhatsApp and Facebook keep you in touch with friends, and you can watch YouTube or plan your next trip with Google Maps. Google Assistant gives you answers at the press of a button, and Wi-Fi, Bluetooth and A-GPS are included. There is a 3.5 mm headphone jack and a micro-USB port, storage can be expanded by up to 32 GB with a memory card, and the phone supports Dual SIM.',
            'ram' => 512,
            'operating_system' => 'Android',
            'os_version' => 9,
            'display_size' => 2.8,
            'resolution' => '320 x 240',
            'height' => 132.2,
            'width' => 56.5,
            'thickness' => 12.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 10 6GB/128GB Dual SIM',
            'price' => 403.09,
            'quantity' => 40,
            'brand_id' => 6,
            'color_id' => 7,
            'description' => 'Modern design, strong performance, 5G speed, a reliable battery, fast charging and a water-resistant body are just some of the advantages of the Sony Xperia 10 III. Its three lenses (wide, ultra-wide and telephoto) let you take striking portraits, snapshots and detailed landscapes. The automatic mode even recognises animals, adjusts exposure and keeps the picture as sharp as possible, whether it is a restaurant menu, a dim evening scene, a backlit face or movement. The phone also records 4K video.',
            'ram' => 6000,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.0,
            'resolution' => '2520 x 1080',
            'height' => 154.0,
            'width' => 68.0,
            'thickness' => 8.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 1 12GB/256GB',
            'price' => 1299.00,
            'quantity' => 3,
            'brand_id' => 6,
            'color_id' => 8,
            'description' => 'This smartphone wins you over with a unique water- and dust-resistant design and surprising battery life. Its biggest strength is the four-lens camera that automatically focuses even on moving subjects, with a sophisticated 3D iToF sensor and many modes. CineAlta technology lets you shoot films with colour and settings similar to those used by professional filmmakers, and you can review your work on the 4K HDR OLED display.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.5,
            'resolution' => '1644 x 3840',
            'height' => 165.0,
            'width' => 71.0,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 5',
            'price' => 999.00,
            'quantity' => 0,
            'brand_id' => 6,
            'color_id' => 9,
            'description' => 'The Xperia 5 III is compact and powerful, combining the fast autofocus of its predecessor with new optics reaching up to 105 mm. Whether you are taking photos or gaming, it fits your hand and exceeds your expectations.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.1,
            'resolution' => '2520 x 1080',
            'height' => 157.0,
            'width' => 68.0,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia 150 Single Sim',
            'price' => 34.90,
            'quantity' => 61,
            'brand_id' => 5,
            'color_id' => 1,
            'description' => 'The Nokia 150 combines a nice design with practicality. The polycarbonate body keeps its colour for years, and under the clear 2.4-inch colour display there are large, easy-to-press buttons.',
            'ram' => 512,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 2.4,
            'resolution' => '240 x 320',
            'height' => 118.0,
            'width' => 50.0,
            'thickness' => 13.5,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy S24 8GB/256GB',
            'price' => 799.00,
            'quantity' => 15,
            'brand_id' => 1,
            'color_id' => 8,
            'description' => 'A compact flagship that fits comfortably in one hand. The bright 120 Hz display adapts its refresh rate to what you are doing, and the triple camera with a 3x telephoto lens takes detailed photos day and night. Built-in AI features translate calls live, summarise notes and help you edit photos, and Samsung promises seven years of software updates.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.2,
            'resolution' => '2340 x 1080',
            'height' => 147.0,
            'width' => 70.6,
            'thickness' => 7.6,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy A55 5G 8GB/128GB',
            'price' => 399.00,
            'quantity' => 25,
            'brand_id' => 1,
            'color_id' => 3,
            'description' => 'A mid-range phone with a premium feel: a metal frame, a glass back and IP67 water and dust resistance. The large Super AMOLED display is smooth and vivid, the 50 MP main camera handles low light well, and the 5000 mAh battery easily lasts a full day.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.6,
            'resolution' => '2340 x 1080',
            'height' => 161.1,
            'width' => 77.4,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy Z Flip6 12GB/256GB',
            'price' => 1099.00,
            'quantity' => 5,
            'brand_id' => 1,
            'color_id' => 4,
            'description' => 'A full-size smartphone that folds in half to fit any pocket. The large cover screen shows notifications, widgets and a camera preview without opening the phone, and the hinge holds any angle for hands-free video calls and photos. The 50 MP main camera and a bigger battery make this the most capable Flip so far.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.7,
            'resolution' => '2640 x 1080',
            'height' => 165.1,
            'width' => 71.9,
            'thickness' => 6.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 15 128GB',
            'price' => 849.00,
            'quantity' => 20,
            'brand_id' => 7,
            'color_id' => 6,
            'description' => 'The iPhone 15 brings the Dynamic Island, a 48 MP main camera and USB-C to the standard model. Photos are sharper, with automatic portrait mode and a 2x telephoto option, and the colour-infused glass back feels as good as it looks. The A16 Bionic chip keeps everything fast and efficient.',
            'ram' => 6144,
            'operating_system' => 'iOS',
            'os_version' => 17,
            'display_size' => 6.1,
            'resolution' => '2556 x 1179',
            'height' => 147.6,
            'width' => 71.6,
            'thickness' => 7.8,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 15 Pro 256GB',
            'price' => 1199.00,
            'quantity' => 8,
            'brand_id' => 7,
            'color_id' => 8,
            'description' => 'A light and strong titanium design, the customisable Action button and the A17 Pro chip with console-class graphics. The pro camera system includes a 48 MP main camera and a 3x telephoto lens, and USB 3 speeds make moving large videos to a computer quick.',
            'ram' => 8192,
            'operating_system' => 'iOS',
            'os_version' => 17,
            'display_size' => 6.1,
            'resolution' => '2556 x 1179',
            'height' => 146.6,
            'width' => 70.6,
            'thickness' => 8.25,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone SE 64GB (3rd generation)',
            'price' => 459.00,
            'quantity' => 0,
            'brand_id' => 7,
            'color_id' => 1,
            'description' => 'The classic compact iPhone with a Home button and Touch ID, powered by the same A15 Bionic chip as much more expensive models. It supports 5G, takes great photos with Smart HDR 4, and fits easily in one hand and any pocket.',
            'ram' => 4096,
            'operating_system' => 'iOS',
            'os_version' => 15,
            'display_size' => 4.7,
            'resolution' => '1334 x 750',
            'height' => 138.4,
            'width' => 67.3,
            'thickness' => 7.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Google Pixel 8 8GB/128GB',
            'price' => 699.00,
            'quantity' => 12,
            'brand_id' => 8,
            'color_id' => 2,
            'description' => 'Google\'s compact flagship with the Tensor G3 chip and seven years of Android updates. The camera uses Google\'s computational photography for excellent photos in any light, and tools like Magic Editor, Best Take and Audio Magic Eraser fix photos and videos after you take them.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.2,
            'resolution' => '2400 x 1080',
            'height' => 150.5,
            'width' => 70.8,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Google Pixel 8a 8GB/128GB',
            'price' => 499.00,
            'quantity' => 18,
            'brand_id' => 8,
            'color_id' => 3,
            'description' => 'Most of the Pixel 8 experience at a lower price. The same Tensor G3 chip, the same seven years of updates and Google\'s AI features, with a smooth 120 Hz display and a camera that takes great photos without any effort.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.1,
            'resolution' => '2400 x 1080',
            'height' => 152.1,
            'width' => 72.7,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi 14 12GB/512GB',
            'price' => 899.00,
            'quantity' => 7,
            'brand_id' => 3,
            'color_id' => 7,
            'description' => 'A compact flagship with Leica optics. The three 50 MP cameras, including a floating telephoto lens, produce natural, detailed photos, and the Snapdragon 8 Gen 3 chip handles anything. The 4610 mAh battery charges from empty to full in about half an hour with the 90 W charger.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.36,
            'resolution' => '2670 x 1200',
            'height' => 152.8,
            'width' => 71.5,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi Note 13 Pro 8GB/256GB',
            'price' => 329.00,
            'quantity' => 30,
            'brand_id' => 3,
            'color_id' => 5,
            'description' => 'A 200 MP main camera with optical image stabilisation in an affordable phone. The large 120 Hz AMOLED display is bright enough for direct sunlight, and 67 W turbo charging gets you through the day after a short break.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.67,
            'resolution' => '2712 x 1220',
            'height' => 161.2,
            'width' => 74.2,
            'thickness' => 8.0,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'OnePlus 12 12GB/256GB',
            'price' => 899.00,
            'quantity' => 10,
            'brand_id' => 9,
            'color_id' => 2,
            'description' => 'A fast flagship with a brilliant 2K display, the Snapdragon 8 Gen 3 chip and a Hasselblad-tuned triple camera. The 5400 mAh battery lasts well over a day and charges fully in under half an hour, wired or even wirelessly at 50 W.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.82,
            'resolution' => '3168 x 1440',
            'height' => 164.3,
            'width' => 75.8,
            'thickness' => 9.15,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'OnePlus Nord 4 12GB/256GB',
            'price' => 449.00,
            'quantity' => 14,
            'brand_id' => 9,
            'color_id' => 9,
            'description' => 'A rare metal unibody design in the mid-range. It is smooth and fast thanks to the Snapdragon 7+ Gen 3 chip, has a large 120 Hz OLED display, and its 5500 mAh battery charges from 1 to 100 % in about half an hour.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.74,
            'resolution' => '2772 x 1240',
            'height' => 162.6,
            'width' => 75.0,
            'thickness' => 8.0,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Motorola Edge 50 Pro 12GB/512GB',
            'price' => 549.00,
            'quantity' => 9,
            'brand_id' => 10,
            'color_id' => 5,
            'description' => 'A curved 144 Hz pOLED display and a vegan-leather back give this phone a premium look. The 50 MP camera system is colour-validated by Pantone for true-to-life skin tones, and 125 W TurboPower charging gives you a day\'s power in minutes.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.7,
            'resolution' => '2712 x 1220',
            'height' => 161.2,
            'width' => 72.4,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Motorola Moto G54 5G 8GB/256GB',
            'price' => 199.00,
            'quantity' => 40,
            'brand_id' => 10,
            'color_id' => 3,
            'description' => 'Plenty of phone for the price: 5G, 256 GB of storage, a smooth 120 Hz display and stereo speakers with Dolby Atmos. The 5000 mAh battery easily lasts two days of normal use.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.5,
            'resolution' => '2400 x 1080',
            'height' => 161.6,
            'width' => 73.8,
            'thickness' => 8.0,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Honor Magic6 Pro 12GB/512GB',
            'price' => 1299.00,
            'quantity' => 3,
            'brand_id' => 11,
            'color_id' => 9,
            'description' => 'Honor\'s flagship with a 180 MP periscope telephoto camera and a very bright, eye-friendly display. The silicon-carbon battery packs 5600 mAh into a slim body, and the reinforced glass makes the screen highly resistant to drops.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.8,
            'resolution' => '2800 x 1280',
            'height' => 162.5,
            'width' => 75.8,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Honor 200 12GB/512GB',
            'price' => 499.00,
            'quantity' => 0,
            'brand_id' => 11,
            'color_id' => 2,
            'description' => 'A slim, light phone built for portraits. The camera system and its studio-style portrait modes were developed with the Parisian photo studio Harcourt, and the curved OLED display and 100 W charging round off the package.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.7,
            'resolution' => '2664 x 1200',
            'height' => 161.5,
            'width' => 74.8,
            'thickness' => 7.7,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Fairphone 5 8GB/256GB',
            'price' => 699.00,
            'quantity' => 6,
            'brand_id' => 12,
            'color_id' => 3,
            'description' => 'The sustainable choice: a modular phone you can repair yourself with a single screwdriver, made with fair and recycled materials. The battery, screen, cameras and other parts are replaceable, and Fairphone plans software support until 2031.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.46,
            'resolution' => '2770 x 1224',
            'height' => 161.6,
            'width' => 75.8,
            'thickness' => 9.6,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nothing Phone (2) 12GB/256GB',
            'price' => 599.00,
            'quantity' => 11,
            'brand_id' => 13,
            'color_id' => 7,
            'description' => 'A transparent back with the unique Glyph interface: light strips that show notifications, charging progress and timers so you can keep the screen face down. Nothing OS is clean and fast, and the dual 50 MP camera takes sharp photos.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.7,
            'resolution' => '2412 x 1080',
            'height' => 162.1,
            'width' => 76.4,
            'thickness' => 8.6,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 1 VI 12GB/256GB',
            'price' => 1399.00,
            'quantity' => 4,
            'brand_id' => 6,
            'color_id' => 9,
            'description' => 'Sony\'s flagship for creators, with camera technology from its Alpha cameras. The telephoto lens zooms continuously from 85 to 170 mm, and the phone keeps rare extras such as a headphone jack, a microSD slot and a two-stage shutter button.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.5,
            'resolution' => '2340 x 1080',
            'height' => 162.0,
            'width' => 74.0,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia G42 5G 6GB/128GB',
            'price' => 199.00,
            'quantity' => 22,
            'brand_id' => 5,
            'color_id' => 5,
            'description' => 'An affordable 5G phone designed to be repaired: the battery, display and charging port can be replaced at home in minutes with the QuickFix guides. It has a 50 MP triple camera, a battery that lasts up to three days and two years of Android updates.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.56,
            'resolution' => '1612 x 720',
            'height' => 165.0,
            'width' => 75.8,
            'thickness' => 8.55,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei nova 12 SE 8GB/256GB',
            'price' => 299.00,
            'quantity' => 13,
            'brand_id' => 2,
            'color_id' => 7,
            'description' => 'A slim, elegant phone with a 108 MP main camera and a large OLED display. It charges quickly at 66 W and offers plenty of storage for photos and videos.',
            'ram' => 8192,
            'operating_system' => 'EMUI',
            'os_version' => 14,
            'display_size' => 6.67,
            'resolution' => '2400 x 1080',
            'height' => 161.0,
            'width' => 74.9,
            'thickness' => 7.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia 3210 4G (2024)',
            'price' => 79.99,
            'quantity' => 2,
            'brand_id' => 5,
            'color_id' => 4,
            'description' => 'The legendary Nokia 3210 is back, 25 years later, with 4G, a colour screen, a 2 MP camera, Bluetooth and USB-C. The battery lasts for days, Snake is of course included, and it is the perfect phone for a digital detox or as a backup.',
            'ram' => 64,
            'operating_system' => 'S30+',
            'os_version' => null,
            'display_size' => 2.4,
            'resolution' => '320 x 240',
            'height' => 122.0,
            'width' => 52.0,
            'thickness' => 13.1,
        ]);
        $smartphone->save();
    }
}
