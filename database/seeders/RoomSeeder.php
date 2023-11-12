<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rooms = [
            [
                'title' => '204',
                'room_type_id' => '1',
                'totalseats' => '3',
                'vacancy' => '3'
            ],
            [
                'title' => '205',
                'room_type_id' => '2',
                'totalseats' => '4',
                'vacancy' => '4'
            ],
        ];
        Room::insert($rooms);
    }
}
