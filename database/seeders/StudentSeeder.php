<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $student = [
            'rollno' => '170131',
            'name' => 'Shahriar Ahmed',
            'email' => 'shahriarabiddut@gmail.com',
            'password' => bcrypt('Password')
        ];
        Student::insert($student);
    }
}
