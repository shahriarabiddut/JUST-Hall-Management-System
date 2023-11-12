<?php

namespace App\Http\Controllers\Staff;

use App\Models\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    //Staff Index
    public function index()
    {
        //
        $data = Balance::all();
        return view('staff.balance.index', ['data' => $data]);
    }
}
