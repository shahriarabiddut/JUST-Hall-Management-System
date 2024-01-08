<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $staff = [
            [
                'name' => 'Staff 1',
                'email' => 'shahriarabiddut@gmail.com',
                'type' => 'staff',
                'password' => bcrypt('Password')
            ], [
                'name' => 'Provost',
                'email' => 'provost@gmail.com',
                'type' => 'provost',
                'password' => bcrypt('Password')
            ], [
                'name' => 'Assistant Provost',
                'email' => 'aprovost@gmail.com',
                'type' => 'aprovost',
                'password' => bcrypt('Password')
            ]

        ];
        Staff::insert($staff);
    }
}
