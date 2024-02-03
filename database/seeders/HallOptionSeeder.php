<?php

namespace Database\Seeders;

use App\Models\HallOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HallOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $options = [
            [
                'name' => 'title',
                'value' => 'LaraHall'
            ],
            [
                'name' => 'fixed_cost_charge',
                'value' => '50'
            ],
            [
                'name' => 'systemname',
                'value' => 'Hall Automation System'
            ], [
                'name' => 'dashboard_image',
                'value' => 'img/just.jpg'
            ],
            [
                'name' => 'Favicon',
                'value' => 'img/justcse.png'
            ],
            [
                'name' => 'Login Background',
                'value' => 'img/bglogin.jpg'
            ],
            [
                'name' => 'System Email',
                'value' => 'justcsebd@gmail.com'
            ],
            [
                'name' => 'System Email Sender Name',
                'value' => 'JUST Hall System'
            ], [
                'name' => 'Hall Name',
                'value' => 'Sheikh Hasina Hall'
            ],
            [
                'name' => 'Printing Secret',
                'value' => 'value'
            ],
            [
                'name' => 'print',
                'value' => '1'
            ],
            [
                'name' => 'masters_fixed_cost',
                'value' => '50'
            ],
        ];
        HallOption::insert($options);
    }
}
