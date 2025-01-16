<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            'email' => env('ADMIN_EMAIL', 'admin@eshop.sk'),
            'password' => Hash::make(env('ADMIN_PASSWORD', '123456789')),
            'role' => 'admin',
        ]);
        $admin->save();
    }
}
