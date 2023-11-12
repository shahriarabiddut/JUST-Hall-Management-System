<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $student_id = Auth::user()->id;
        $data = Payment::select('*')->where('student_id','=',$student_id)->orderBy("id", "desc")->get();
        return view('profile.balance.payment.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('profile.balance.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Payment;
        $request->validate([
            'student_id' => 'required',
            'payment_method' => 'required',
            'mobileno' => 'required',
            'amount' => 'required',
            'createdby' => 'required',
        ]);
       

        $data->student_id = $request->student_id;
        $data->payment_method = $request->payment_method;
        $data->mobileno = $request->mobileno;
        $data->amount = $request->amount;
        $data->transid = $request->transid;
        $data->status = 0;
        $data->createdby = $request->createdby;
        $data->save();
        return redirect('student/payments')->with('success','Payment Data has been added Successfully!');
    }

}
