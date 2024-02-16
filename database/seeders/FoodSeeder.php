<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $foods = [
            [
                'food_time_id' => '1',
                'food_name' => 'Chicken',
                'status' => 0,
                'hall_id' => 1,
            ],
            [
                'food_time_id' => '1',
                'food_name' => 'Fish',
                'status' => 0,
                'hall_id' => 1,
            ], [
                'food_time_id' => '1',
                'food_name' => 'Egg',
                'status' => 0,
                'hall_id' => 1,
            ], [
                'food_time_id' => '2',
                'food_name' => 'Chicken',
                'status' => 0,
                'hall_id' => 1,
            ],
            [
                'food_time_id' => '2',
                'food_name' => 'Fish',
                'status' => 0,
                'hall_id' => 1,
            ], [
                'food_time_id' => '2',
                'food_name' => 'Egg',
                'status' => 0,
                'hall_id' => 1,
            ],
        ];
        Food::insert($foods);
    }
}
