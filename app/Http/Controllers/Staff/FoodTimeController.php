<?php

namespace App\Http\Controllers\Staff;

use App\Models\Food;
use App\Models\FoodTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FoodTimeHall;
use Illuminate\Support\Facades\Auth;

class FoodTimeController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::guard('staff')->user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            }
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
        $data = FoodTimeHall::all()->where('hall_id', $this->hall_id);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = FoodTimeHall::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        }
        //
        return view('staff.foodtime.show', ['data' => $data]);
    }
    public function edit(string $id)
    {

        $data = FoodTimeHall::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
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
        $data = FoodTimeHall::find($id);
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        }
        $request->validate([
            'price' => 'required',
        ]);
        $data->price = $request->price;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'update', 'Food Time ( ' . $data->food_time->title . ' ) -  has been updated Successfully to price ' . $data->price . ' /= Taka', $this->hall_id);
        //Saved
        return redirect()->route('staff.foodtime.index')->with('success', 'Food Time has been updated Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
    }
    public function active($id)
    {
        $data = FoodTimeHall::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        }
        //
        $data->status = 1;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'activated', 'Food Time ( ' . $data->food_time->title . ' ) -  has been activated Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.foodtime.index')->with('success', 'FoodTime Activate Successfully!');
    }
    public function disable($id)
    {
        $data = FoodTimeHall::find($id);
        //
        if ($data == null) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.foodtime.index')->with('danger', 'Not Permitted!');
        }
        //
        $data->status = 0;

        // foreach ($data->food_time->food as $fitem) {
        //     $dataDisable = Food::find($fitem->id);
        //     $dataDisable->status = 0;
        //     $dataDisable->save();
        // }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'Disabled', 'Food Time ( ' . $data->food_time->title . ' ) -  has been Disabled Successfully!', $this->hall_id);
        //Saved
        $data->save();
        return redirect()->route('staff.foodtime.index')->with('danger', 'FoodTime and related FoodItems Disabled Successfully!');
    }
}
