<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            "role" => "admin",
            "first_name" => "Admin",
            "last_name" => "Admin",
            "email" => "admin@gmail.com",
            "phone" => "9999999999",
            "password" => Hash::make("12345678")
        ]);
    }
}
