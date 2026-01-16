<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

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
        Admin::create([
            "name" => "admin",
            "email" => "admin@email.com",
            "password" => "password",
            "phone" => "123456",
        ]);
        $this->call([CategoriesTableSeeder::class, SettingsSeeder::class]);
        $this->call(CategoriesTableSeeder::class);
    }
}
