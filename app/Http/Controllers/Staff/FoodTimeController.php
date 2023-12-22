<?php

namespace App\Http\Controllers\Staff;

use App\Models\Food;
use App\Models\FoodTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodTimeController extends Controller
{
    public function index()
    {
        $data = FoodTime::all();
        return view('staff.foodtime.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.foodtime.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new FoodTime;
        $request->validate([
            'title' => 'required',
            'detail' => 'required',
            'status' => 'required',
            'price' => 'required',
        ]);
        $data->title = $request->title;
        $data->detail = $request->detail;
        $data->price = $request->price;
        $data->status = $request->status;
        $data->createdby = $request->createdby;
        $data->save();

        return redirect('staff/foodtime')->with('success', 'Foodtime has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = FoodTime::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        //
        return view('staff.foodtime.show', ['data' => $data]);
    }
    public function edit(string $id)
    {

        $data = FoodTime::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        //
        return view('staff.foodtime.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = FoodTime::find($id);

        $request->validate([
            'detail' => 'required',
            'price' => 'required',
        ]);
        $data->detail = $request->detail;
        $data->price = $request->price;
        $data->save();
        return redirect('staff/foodtime')->with('success', 'Food Time Data has been updated Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = FoodTime::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        //
        $data->delete();
        return redirect('staff/foodtime')->with('danger', 'Data has been deleted Successfully!');
    }
    public function active($id)
    {
        $data = FoodTime::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        //
        $data->status = 1;
        $data->save();
        return redirect('staff/foodtime')->with('success', 'FoodTime Activate Successfully!');
    }
    public function disable($id)
    {
        $data = FoodTime::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        //
        $data->status = 0;

        foreach ($data->food as $fitem) {
            $dataDisable = Food::find($fitem->id);
            $dataDisable->status = 0;
            $dataDisable->save();
        }

        $data->save();
        return redirect('staff/foodtime')->with('danger', 'FoodTime and related FoodItems Disabled Successfully!');
    }
}
