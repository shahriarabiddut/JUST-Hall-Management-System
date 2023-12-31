<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Department;
use App\Models\StaffPayment;

use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //
    public function index()
    {
        $data = Staff::all();
        return view('staff.staff.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $departs = Department::all();
        return view('staff.staff.create', ['departs' => $departs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Staff;
        $request->validate([
            'email' => 'required|email|unique:staff',
            'type' => 'required',
        ]);
        $data->email = $request->email;
        $data->password = bcrypt($request->email);
        $data->type = $request->type;
        $data->save();

        return redirect('staff/staff')->with('success', 'Staff Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        return view('staff.staff.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        return view('staff.staff.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = Staff::find($id);
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'bio' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $data->name = $request->name;
        $data->department_id = $request->department_id;
        $data->bio = $request->bio;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->type = $request->type;
        //If user Gieven any PHOTO
        if ($request->hasFile('photo')) {
            $imgpath = $request->file('photo')->store('StaffPhoto', 'public');
        } else {
            $imgpath = $request->prev_photo;
        }
        $data->photo = $imgpath;
        $data->save();

        return redirect('staff/staff')->with('success', 'Staff Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        $data->delete();
        return redirect('staff/staff')->with('danger', 'Data has been deleted Successfully!');
    }
    // Add Payment
    public function add_payment($staff_id)
    {
        //custom biddut
        $staff = Staff::find($staff_id);

        //original
        return view('staffpayment.create', ['staff_id' => $staff_id, 'staff' => $staff]);
    }
    //Save or store payment
    public function save_payment(Request $request, $staff_id)
    {
        $data = new StaffPayment;
        $request->validate([
            'amount' => 'required',
            'amount_date' => 'required',
        ]);
        $data->staff_id = $staff_id;
        $data->amount = $request->amount;
        $data->payment_date = $request->amount_date;

        $data->save();
        return redirect('staff/staff/payment/' . $staff_id . '/add')->with('success', 'Payment added Successfully!');
    }
    public function all_payment(Request $request, $staff_id)
    {
        $data = StaffPayment::where('staff_id', $staff_id)->get();
        $staff = Staff::find($staff_id);

        //custom biddut
        $currentDate = date('Y-m-d');
        $carbonDatedb = Carbon::parse($currentDate);
        $yeardb = $carbonDatedb->year;
        $monthdb = $carbonDatedb->month;
        //custom biddut

        return view('staff.staffpayment.index', ['staff' => $staff, 'staff_id' => $staff_id, 'data' => $data, 'monthdb' => $monthdb]);
    }
    public function delete_payment($id, $staff_id)
    {
        $data = StaffPayment::find($id);
        $data->delete();
        return redirect('staff/staff/payments/' . $staff_id)->with('danger', 'Payment data has been deleted Successfully!');
    }
    public function change(string $id)
    {
        //
        $departs = Department::all();
        $data = Staff::find($id);
        return view('staff.staff.change', ['data' => $data, 'departs' => $departs]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeUpdate(Request $request, $id)
    {
        //
        $data = Staff::find($id);
        $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();

        return redirect('staff/staff')->with('success', 'Staff Email & Password has been updated Successfully!');
    }
}
