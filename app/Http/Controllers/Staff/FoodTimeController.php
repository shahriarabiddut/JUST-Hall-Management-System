<?php

namespace App\Http\Controllers\Staff;

use App\Models\Food;
use App\Models\FoodTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FoodTimeController extends Controller
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
        return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        // return view('staff.foodtime.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        //
        // $data = new FoodTime;
        // $request->validate([
        //     'title' => 'required',
        //     'detail' => 'required',
        //     'status' => 'required',
        //     'price' => 'required',
        // ]);
        // $data->title = $request->title;
        // $data->detail = $request->detail;
        // $data->price = $request->price;
        // $data->status = $request->status;
        // $data->createdby = $request->createdby;
        // $data->save();
        // //Saving History 
        // $HistoryController = new HistoryController();
        // $staff_id = Auth::guard('staff')->user()->id;
        // $HistoryController->addHistory($staff_id, 'add', 'Food Time ( ' . $data->title . ' ) -  has been added Successfully!');
        // //Saved
        // return redirect()->route('staff.foodtime.index')->with('success', 'Foodtime has been added Successfully!');
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'update', 'Food Time ( ' . $data->title . ' ) -  has been updated Successfully!');
        //Saved
        return redirect('staff/foodtime')->with('success', 'Food Time has been updated Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        // $data = FoodTime::find($id);
        // //
        // if ($data == null) {
        //     return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        // }
        // //
        // $data->delete();
        // return redirect('staff/foodtime')->with('danger', 'Data has been deleted Successfully!');
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'activated', 'Food Time ( ' . $data->title . ' ) -  has been activated Successfully!');
        //Saved
        return redirect()->route('staff.foodtime.index')->with('success', 'FoodTime Activate Successfully!');
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'Disabled', 'Food Time ( ' . $data->title . ' ) -  has been Disabled Successfully!');
        //Saved
        $data->save();
        return redirect()->route('staff.foodtime.index')->with('danger', 'FoodTime and related FoodItems Disabled Successfully!');
    }
}
