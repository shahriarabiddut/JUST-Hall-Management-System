<?php

namespace App\Http\Controllers\Staff;

use App\Models\Balance;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Staff\EmailController;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Payment::latest()->get();
        return view('staff.payment.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $studentdata = Student::all();
        return view('staff.payment.create', ['studentdata' => $studentdata]);
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
            'staff_id' => 'required',
            'mobileno' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);


        $data->student_id = $request->student_id;
        $data->staff_id = $request->staff_id;
        $data->transaction_id = 0;
        $data->phone = $request->mobileno;
        $data->amount = $request->amount;
        $data->status = $request->status;
        $data->name = Auth::guard('staff')->user()->name;
        $data->email = Auth::guard('staff')->user()->email;
        $data->address = Auth::guard('staff')->user()->email;
        $data->currency = 'BDT';
        $data->save();
        $status = $data->status;
        // Add in Balance if accepted
        if ($status == 'Accepted') {
            //For adding in balance 
            $newBalance = $data->amount;

            $student_id = $data->student_id;
            $findBalanceAccount = Balance::all()->where('student_id', '=', $student_id)->first();
            $studentCurrentBalance = $findBalanceAccount->balance_amount;
            $studentNewBalance = $studentCurrentBalance + $newBalance;
            $findBalanceAccount->balance_amount = $studentNewBalance;
            $findBalanceAccount->save();
            //Sending Email to User
            $EmailController = new EmailController();
            $staff_id = $data->staff_id;
            $EmailController->paymentEmail($student_id, $newBalance, $staff_id, $status);

            return redirect('staff/payment')->with('success', 'Payment Data has been accepted and added balance to Student!');
        } else {
            return redirect('staff/payment')->with('success', 'Payment Data has been added Successfully!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Payment::find($id);
        if ($data == null) {
            return redirect()->route('staff.payment.index')->with('danger', 'Not Found!');
        }
        return view('staff.payment.show', ['data' => $data]);
    }
    public function acceptby(string $id)
    {
        //
        $data = Payment::find($id);
        if ($data == null) {
            return redirect()->route('staff.payment.index')->with('danger', 'Not Found!');
        }
        if ($data->status == 'Accepted' || $data->status == 'Rejected') {
            return redirect('staff/payment')->with('danger', 'You are Warned!');
        } else {
            if ($data->type != 'roomrequest') {

                $data->status = 'Accepted';
                $data->staff_id = Auth::guard('staff')->user()->id;
                $staff_id = $data->staff_id;
                $status = $data->status;

                //For adding in balance 
                $newBalance = $data->amount;
                $student_id = $data->student_id;
                $findBalanceAccount = Balance::all()->where('student_id', '=', $student_id)->first();
                //Adding Balance
                if ($findBalanceAccount != null) {

                    $studentCurrentBalance = $findBalanceAccount->balance_amount;
                    $studentNewBalance = $studentCurrentBalance + $newBalance;
                    $findBalanceAccount->balance_amount = $studentNewBalance;
                    $findBalanceAccount->save();
                } else {

                    $studentCurrentBalance = 0;
                    $studentNewBalance = $studentCurrentBalance + $newBalance;
                    $newBalanceAccount = new Balance;
                    $newBalanceAccount->student_id = $student_id;
                    $newBalanceAccount->balance_amount = $studentNewBalance;
                    $newBalanceAccount->save();
                }

                //Sending Email to User
                $EmailController = new EmailController();
                $EmailController->paymentEmail($student_id, $newBalance, $staff_id, $status);
                //updating Status
                $data->save();

                return redirect('staff/payment')->with('success', 'Payment has been accepted and added balance to Student!');
            } else {
                $data->status = 'Accepted';
                $data->staff_id = Auth::guard('staff')->user()->id;
                //updating Status
                $data->save();
                return redirect('staff/payment')->with('success', 'Room Allocation Payment has been accepted!');
            }
        }
    }
    public function rejectedby(string $id)
    {
        //
        $data = Payment::find($id);
        if ($data == null) {
            return redirect()->route('staff.payment.index')->with('danger', 'Not Found!');
        }
        if ($data->status == 'Accepted' || $data->status == 'Rejected') {
            return redirect('staff/payment')->with('danger', 'You are Warned!');
        } else {

            $data->status = 'Rejected';
            $data->staff_id = Auth::guard('staff')->user()->id;
            //updating Status
            $data->save();
            //Sending Email to User
            $staff_id = $data->staff_id;
            $newBalance = $data->amount;
            $student_id = $data->student_id;
            $status = $data->status;
            $EmailController = new EmailController();
            $EmailController->paymentEmail($student_id, $newBalance, $staff_id, $status);
            return redirect('staff/payment')->with('danger', 'Payment Data has been rejected!');
        }
    }
}
