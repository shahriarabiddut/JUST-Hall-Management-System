<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hall;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Hall::all();
        return view('admin.hall.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $provost = Staff::all()->where('type', 'provost')->where('hall_id', '0');
        return view('admin.hall.create', ['provost' => $provost]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Hall;
        $request->validate([
            'title' => 'required',
            'staff_id' => 'required',
            'banglatitle' => 'required',
            'logo' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $data->title = $request->title;
        $data->banglatitle = $request->banglatitle;
        $data->staff_id = $request->staff_id;
        $data->type = $request->type;
        $data->status = $request->status;
        //If user Given any PHOTO
        if ($request->hasFile('logo')) {
            $data->logo = 'app/public/' . $request->file('logo')->store('Website', 'public');
        } else {
            $data->logo = 'img/justcse.png';
        }
        $dataStaff = Staff::find($request->staff_id);
        if ($dataStaff->hall_id != null) {
            return redirect()->back()->with('danger', 'User is allready a Provost!');
        }
        $data->save();
        //Staff
        $dataStaff->hall_id = $data->id;
        $dataStaff->save();
        //

        return redirect('admin/hall')->with('success', 'Hall Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Hall::find($id);
        if ($data == null) {
            return redirect()->route('admin.hall.index')->with('danger', 'Not Found!');
        }
        return view('admin.hall.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Hall::find($id);
        $provost = Staff::all()->where('type', 'provost');
        if ($data == null) {
            return redirect()->route('admin.hall.index')->with('danger', 'Not Found!');
        }
        return view('admin.hall.edit', ['data' => $data, 'provost' => $provost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required',
            'staff_id' => 'required',
            'banglatitle' => 'required',
        ]);
        $data = Hall::find($id);
        $data->title = $request->title;
        $data->banglatitle = $request->banglatitle;
        $data->staff_id = $request->staff_id;
        //If user Given any PHOTO
        if ($request->hasFile('logo')) {
            $data->logo = 'app/public/' . $request->file('logo')->store('Website', 'public');
        } else {
            $data->logo = $request->prev_logo;
        }

        if ($request->staff_id != $request->staff_id_old && $request->staff_id != 0) {
            //Staff
            $dataStaff = Staff::find($request->staff_id);
            if ($dataStaff->hall_id != null) {
                return redirect()->back()->with('danger', 'User is allready a Provost!');
            }
            $dataStaff->hall_id = $data->id;
            $dataStaff->save();
            //Update Previous Provost
            $dataStaff2 = Staff::find($request->staff_id_old);
            $dataStaff2->hall_id = 0;
            $dataStaff2->save();
        }
        $data->save();
        return redirect('admin/hall')->with('success', 'Hall Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $data = Hall::find($id);
        if ($data == null) {
            return redirect()->route('admin.hall.index')->with('danger', 'Not Found!');
        }
        $data->delete();
        return redirect('admin/hall')->with('danger', 'Data has been deleted Successfully!');
        // return redirect()->route('admin.hall.index')->with('danger', 'Not Permitted!');

    }
    public function active($id)
    {
        $data = Hall::find($id);
        if ($data == null) {
            return redirect()->route('admin.hall.index')->with('danger', 'Not Found!');
        }
        $data->status = 1;
        $data->save();
        return redirect('admin/hall')->with('success', 'Hall Activate Successfully!');
    }
    public function disable($id)
    {
        $data = Hall::find($id);
        if ($data == null) {
            return redirect()->route('admin.hall.index')->with('danger', 'Not Found!');
        }
        $data->status = 0;
        $data->save();
        return redirect('admin/hall')->with('danger', 'Hall Disabled Successfully!');
    }
}
