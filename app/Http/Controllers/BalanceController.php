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
        $data = Balance::all()->where('student_id', '=', $userid)->first();
        return view('profile.balance.index', ['data' => $data]);
    }


    public function store(String $id)
    {
        //
        $data = new Balance();
        $data->student_id = $id;
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
