<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roomtypes = [
            [
                'title' => '1 Seats',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '1000'
            ],
            [
                'title' => '2 Seats',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '2000'
            ],
            [
                'title' => '3 Seats',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '3000'
            ],
            [
                'title' => '4 Seats',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '4000'
            ],
            [
                'title' => '5 Seats',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '5000'
            ],
            [
                'title' => '6 Seats',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '6000'
            ],

            [
                'title' => 'Gono Room',
                'details' => 'shahriarabiddut@gmail.com',
                'price' => '7000'
            ],
        ];
        RoomType::insert($roomtypes);
    }
}
