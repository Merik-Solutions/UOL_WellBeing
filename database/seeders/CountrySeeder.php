<?php

namespace Database\Seeders;

use App\Models\Country;
use DB;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        Country::firstOrCreate([
            "name_ar" => "مصر",
            "name_en" => "Egypt",
            "code" => "+20",
            "flag" =>
                "https://upload.wikimedia.org/wikipedia/commons/f/fe/Flag_of_Egypt.svg",
            "iso" => "EG",
        ]);
        Country::firstOrCreate([
            "name_ar" => "المملكه السعودية",
            "name_en" => "Saudi Arabia",
            "code" => "+966",
            "flag" =>
                "https://upload.wikimedia.org/wikipedia/commons/0/0d/Flag_of_Saudi_Arabia.svg",
            "iso" => "SA",
        ]);
        Country::firstOrCreate([
            "name_ar" => "الامارات العربية المتحدة",
            "name_en" => "United Arab Emirates",
            "code" => "+971",
            "flag" =>
                "https://upload.wikimedia.org/wikipedia/commons/c/cb/Flag_of_the_United_Arab_Emirates.svg",
            "iso" => "AE",
        ]);
    }
}
