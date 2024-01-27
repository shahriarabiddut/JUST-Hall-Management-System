<?php

namespace App\Http\Controllers\Staff;

use App\Models\Food;
use App\Models\FoodTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('staff')->user()->type == 'provost') {
                return $next($request);
                // return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            } elseif (Auth::guard('staff')->user()->type == 'aprovost') {
                return $next($request);
            } else {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
                return $next($request);
            }
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Food::all();
        return view('staff.food.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $food_time = FoodTime::all()->where('status', '=', '1');
        return view('staff.food.create', ['food_time' => $food_time]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Food;
        $request->validate([
            'food_name' => 'required',
            'food_time_id' => 'required',
            'status' => 'required',
        ]);
        $data->food_time_id = $request->food_time_id;
        $data->food_name = $request->food_name;
        $data->status = $request->status;
        $data->save();

        return redirect('staff/food')->with('success', 'Food Item Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Food::find($id);
        if ($data == null) {
            return redirect()->route('staff.food.index')->with('danger', 'Not Found!');
        }
        $food_time = FoodTime::all()->where('id', '=', $data->food_time_id)->first();
        return view('staff.food.show', ['data' => $data, 'food_time' => $food_time]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $food_time = FoodTime::all()->where('status', '=', '1');
        $data = Food::find($id);
        if ($food_time == null || $data == null) {
            return redirect()->route('staff.food.index')->with('danger', 'Not Found!');
        }
        return view('staff.food.edit', ['data' => $data, 'food_time' => $food_time]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'food_name' => 'required',
            'food_time_id' => 'required',
        ]);
        $data = Food::find($id);
        $data->food_time_id = $request->food_time_id;
        $data->food_name = $request->food_name;
        $data->save();
        return redirect('staff/food')->with('success', 'Food Item Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        return redirect()->route('staff.food.index')->with('danger', 'Not Permitted!');

        // $data = Food::find($id);
        // if ($data == null) {
        //     return redirect()->route('staff.food.index')->with('danger', 'Not Found!');
        // }
        // $data->delete();
        // return redirect('staff/food')->with('danger', 'Data has been deleted Successfully!');
    }
    public function active($id)
    {
        $data = Food::find($id);
        if ($data == null) {
            return redirect()->route('staff.food.index')->with('danger', 'Not Found!');
        }
        $dataActive = FoodTime::find($data->food_time_id);
        if ($dataActive->status == 1) {
            $data->status = 1;
            $data->save();
            return redirect('staff/food')->with('success', 'Food Activate Successfully!');
        } else {
            return redirect('staff/food')->with('danger', 'Related FoodTime is not Active!');
        }
    }
    public function disable($id)
    {
        $data = Food::find($id);
        if ($data == null) {
            return redirect()->route('staff.food.index')->with('danger', 'Not Found!');
        }
        $data->status = 0;
        $data->save();
        return redirect('staff/food')->with('danger', 'Food Disabled Successfully!');
    }
}
