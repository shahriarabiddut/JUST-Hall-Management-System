<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{

    //Student Index
    public function index()
    {
        $userid = Auth::user()->id;
        if (Auth::user()->hall->status == 0) {
            return redirect()->route('student.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
        }
        $data = Balance::all()->where('student_id', '=', $userid)->first();
        return view('profile.balance.index', ['data' => $data]);
    }


    public function store(String $id, String $hall_id)
    {
        //
        $data = new Balance();
        $data->student_id = $id;
        $data->hall_id = $hall_id;
        $data->balance_amount = 0;

        $data->save();
    }
    //Admin Index
    public function adminIndex()
    {
        $data = Balance::all();
        return view('admin.student.balance.index', ['data' => $data]);
    }
}
