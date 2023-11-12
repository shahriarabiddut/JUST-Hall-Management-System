<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Process;

class ProcessController extends Controller
{
    // Command To Deduct Fixed Meal Cost
    public function deductBalance()
    {
        $result = Process::run('php artisan send:sms');
        return redirect()->route('admin.student.balances')->with('success', 'Fixed Cost Charged Successfully!');
    }
    // public function test()
    // {
    //     $result = Process::run('php artisan send:sms');
    //     return $result->output();
    // }
}
