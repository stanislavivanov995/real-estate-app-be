<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::truncate();

        Category::create([
            'name' => 'Hotel',
        ]);
        Category::create([
            'name' => 'Apartment',
        ]);
        Category::create([
            'name' => 'House',
        ]);
        Category::create([
            'name' => 'Hostel / room',
        ]);
        Category::create([
            'name' => 'Camping',
        ]);
    }
}

/*
To seed MySQL db, execute once in terminal "sail/php artisan db:seed --class=CategorySeeder" command
*/
