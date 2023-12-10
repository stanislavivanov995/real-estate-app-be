<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estate;

class TestEstatesSeeder extends Seeder
{
    public function run(): void
    {
        Estate::truncate();

        Estate::create([
            'id' => 10,
            'user_id' => 5,
            'name' => 'Estate One',
            'description' => 'This is a description of Estate One.',
            'price' => 100,
            'currency' => 'lv',
            'longitude' => 0.111111,
            'latitude' => 1.222222,
            'category_id' => 1,
            'rooms' => 3,
            'arrive_hour' => '14:00',
            'leave_hour' => '11: 00'
        ]);

        Estate::create([
            'id' => 11,
            'user_id' => 4,
            'name' => 'Estate Two',
            'description' => 'This is a description of Estate Two.',
            'price' => 200,
            'currency' => 'lv',
            'longitude' => 0.111111,
            'latitude' => 1.222222,
            'category_id' => 1,
            'rooms' => 3,
            'arrive_hour' => '14:00',
            'leave_hour' => '11: 00'
        ]);
    }
}
