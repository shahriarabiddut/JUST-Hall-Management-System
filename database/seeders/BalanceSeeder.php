<?php

namespace Database\Seeders;

use App\Models\Balance;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $student = [
            'student_id' => '1',
            'balance_amount' => '500',
        ];
        Balance::insert($student);
    }
}
