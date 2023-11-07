<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Hotel',
        ]);
        Category::create([
            'name' => 'Apartament',
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
