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
        $provost = Staff::all()->where('type', 'provost');
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
            'status' => 'required',
        ]);
        $data->title = $request->title;
        $data->staff_id = $request->staff_id;
        $data->status = $request->status;
        $data->save();

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
        ]);
        $data = Hall::find($id);
        $data->title = $request->title;
        $data->staff_id = $request->staff_id;
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
