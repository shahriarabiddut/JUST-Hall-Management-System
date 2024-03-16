<?php

namespace Database\Seeders;

use App\Models\FoodTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $food_times = [
            [
                'title' => 'Lunch',
                'detail' => 'Lunch Meal',
                'status' => 0,
                'price' => 0,
                'createdby' => 'Automated',
            ],
            [
                'title' => 'Dinner',
                'detail' => 'Dinner Meal',
                'status' => 0,
                'price' => 0,
                'createdby' => 'Automated',
            ],
            [
                'title' => 'Suhr',
                'detail' => 'Suhr Meal',
                'status' => 0,
                'price' => 0,
                'createdby' => 'Automated',
            ],
            [
                'title' => 'Special',
                'details' => 'Special Meal',
                'status' => 0,
                'price' => 0,
                'createdby' => 'Automated',
            ]
        ];
        FoodTime::insert($food_times);
    }
}
