<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Department;
use App\Models\StaffPayment;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('staff.staff.create');
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'add', 'Staff (' . $data->type . ' ) - ' . $data->name . ' has been added Successfully!');
        //Saved
        return redirect()->route('staff.staff.index')->with('success', 'Staff has been added Successfully!');
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
            'bio' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $data->name = $request->name;
        $data->bio = $request->bio;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->type = $request->type;
        //If user Gieven any PHOTO
        if ($request->hasFile('photo')) {
            $imgpath = 'app/public/' . $request->file('photo')->store('StaffPhoto', 'public');
        } else {
            $imgpath = $request->prev_photo;
        }
        $data->photo =  $imgpath;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'update', 'Staff (' . $data->type . ' ) - ' . $data->name . ' has been updated Successfully!');
        //Saved
        return redirect()->route('staff.staff.index')->with('success', 'Staff has been updated Successfully!');
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'delete', 'Staff (' . $data->type . ' ) - ' . $data->name . ' has been updated Successfully!');
        //Saved
        return redirect()->route('staff.staff.index')->with('danger', 'Data has been deleted Successfully!');
    }

    public function change(string $id)
    {
        //
        $data = Staff::find($id);
        return view('staff.staff.change', ['data' => $data]);
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
