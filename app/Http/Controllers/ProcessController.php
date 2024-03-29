<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use App\Http\Controllers\Staff\HistoryController;

class ProcessController extends Controller
{
    // Command To Deduct Fixed Meal Cost
    public function deductBalance()
    {
        $result = Process::run('php artisan send:sms');
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'fixed cost', 'Fixed Cost Charged Successfully!', Auth::guard('staff')->user()->hall->id);
        //Saved
        return redirect()->route('admin.student.balances')->with('success', 'Fixed Cost Charged Successfully!');
    }

    // public function test()
    // {
    //     $result = Process::run('php artisan send:sms');
    //     return $result->output();
    // }
}
