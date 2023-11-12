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
                'value' => 'img/justcse.png'
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
                'name' => 'IP Address of Printer',
                'value' => '\'192.168.1.87\''
            ],
            [
                'name' => 'backup',
                'value' => '0'
            ],
        ];
        HallOption::insert($options);
    }
}
