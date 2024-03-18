<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Hall;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //
    public function index()
    {
        $data = Staff::all();
        return view('admin.staff.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $halls = Hall::all();
        return view('admin.staff.create', ['halls' => $halls]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Staff;
        $request->validate([
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:staff',
            'type' => 'required',
            'hall_id' => 'required',
        ]);
        $data->hall_id = $request->hall_id;
        $data->email = $request->email;
        $data->password = bcrypt($request->email);
        $data->type = $request->type;
        $data->status = 1;
        $data->save();

        return redirect('admin/staff')->with('success', 'Staff Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('admin.staff.index')->with('danger', 'Not Found!');
        }
        return view('admin.staff.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Staff::find($id);
        $halls = Hall::all();
        if ($data == null) {
            return redirect()->route('admin.staff.index')->with('danger', 'Not Found!');
        }
        return view('admin.staff.edit', ['data' => $data, 'halls' => $halls]);
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
            'type' => 'required',
            'hall_id' => 'required',
        ]);
        $data->hall_id = $request->hall_id;
        $data->name = $request->name;
        $data->bio = $request->bio;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->type = $request->type;
        //If user Gieven any PHOTO
        if ($request->hasFile('photo')) {
            $imgpath =  'app/public/' . $request->file('photo')->store('StaffPhoto', 'public');
        } else {
            $imgpath = $request->prev_photo;
        }
        $data->photo = $imgpath;
        $data->save();

        return redirect('admin/staff')->with('success', 'Staff Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('admin.staff.index')->with('danger', 'Not Found!');
        }
        if ($data->hall->enable_delete != 1) {
            return redirect()->route('admin.staff.index')->with('danger', 'Not Permitted!');
        }
        if ($data->status == 0) {
            return redirect()->route('admin.staff.index')->with('danger', 'No Action Needed!');
        }
        $data->status = 0;
        $data->hall_id = 0;
        $data->save();
        return redirect('admin/staff')->with('danger', 'Staff data has been disabled Successfully!');
    }
    public function activate($id)
    {
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('admin.staff.index')->with('danger', 'Not Found!');
        }
        if ($data->status == 1) {
            return redirect()->route('admin.staff.index')->with('danger', 'No Action Needed!');
        }
        $data->status = 1;
        $data->save();
        return redirect()->route('admin.staff.index')->with('success', 'Staff Data has been Activated Successfully and Please! Assign Hall to this User!');
    }

    public function change(string $id)
    {
        //
        $data = Staff::find($id);
        return view('admin.staff.change', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeUpdate(Request $request, $id)
    {
        //
        $data = Staff::find($id);
        $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required',

        ]);

        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();

        return redirect('admin/staff')->with('success', 'Staff Email & Password has been updated Successfully!');
    }
}
