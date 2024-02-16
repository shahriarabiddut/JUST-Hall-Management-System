<?php

namespace App\Http\Controllers\Admin;

use App\Models\Food;
use App\Models\Hall;
use App\Models\Room;
use App\Models\Order;
use App\Models\Staff;
use App\Models\History;
use App\Models\Payment;
use App\Models\Student;
use App\Models\FoodTime;
use App\Models\MealToken;
use App\Models\RoomRequest;
use App\Models\FoodTimeHall;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AllocatedSeats;
use App\Models\Balance;

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
            'type' => 'required',
            'status' => 'required',
            'fixed_cost' => 'required',
            'fixed_cost_masters' => 'required',
        ]);
        $data->title = $request->title;
        $data->banglatitle = $request->banglatitle;
        $data->staff_id = $request->staff_id;
        $data->type = $request->type;
        $data->status = $request->status;
        $data->print = 0;
        $data->secret = 'value';
        $data->fixed_cost = $request->fixed_cost;
        $data->fixed_cost_masters = $request->fixed_cost_masters;
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
        //Create FoodTime Relation Table
        $dataFoodTime = FoodTime::all();
        foreach ($dataFoodTime as $FoodTime) {
            $dataFoodTimeHall = new FoodTimeHall();
            $dataFoodTimeHall->hall_id = $data->id;
            $dataFoodTimeHall->food_time_id = $FoodTime->id;
            $dataFoodTimeHall->price = $FoodTime->price;
            $dataFoodTimeHall->status = 0;
            $dataFoodTimeHall->save();
        }
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
            'print' => 'required',
            'secret' => 'required',
            'fixed_cost' => 'required',
            'fixed_cost_masters' => 'required',
        ]);
        $data = Hall::find($id);
        $data->title = $request->title;
        $data->banglatitle = $request->banglatitle;
        $data->staff_id = $request->staff_id;
        $data->print = $request->print;
        $data->secret = $request->secret;
        $data->fixed_cost = $request->fixed_cost;
        $data->fixed_cost_masters = $request->fixed_cost_masters;
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
        //Delete FoodTime Relation Table
        $dataFoodTime = FoodTime::all();
        foreach ($dataFoodTime as $FoodTime) {
            $dataFoodTimeHall = FoodTimeHall::all()->where('hall_id', $data->id)->where('food_time_id', $FoodTime->id)->first();
            $dataFoodTimeHall->delete();
        }
        //Free Provost
        $dataStaff2 = Staff::find($data->staff_id);
        $dataStaff2->hall_id = 0;
        $dataStaff2->save();
        //Free Staffs
        $Staffs = Staff::all()->where('hall_id', $data->id);
        foreach ($Staffs as $Staff) {
            $Staff->hall_id = 0;
            $Staff->save();
        }
        //Delete Students
        $Students = Student::all()->where('hall_id', $data->id);
        foreach ($Students as $student) {
            $balance = Balance::all()->where('student_id', $student->id)->first();
            $balance->delete();
            $allocatedseat = new AllocatedSeatController();
            $allocatedseat->destroy($student->allocatedRoom->id);
            $student->delete();
        }
        //Delete Foods
        $Foods = Food::all()->where('hall_id', $data->id);
        foreach ($Foods as $student) {
            $student->delete();
        }
        //Delete Orders
        $Orders = Order::all()->where('hall_id', $data->id);
        foreach ($Orders as $student) {
            $student->delete();
        }
        //Delete Meal Token
        $MealToken = MealToken::all()->where('hall_id', $data->id);
        foreach ($MealToken as $student) {
            $student->delete();
        }
        //Delete Room Requests
        $RoomRequests = RoomRequest::all()->where('hall_id', $data->id);
        foreach ($RoomRequests as $student) {
            $student->delete();
        }
        //Delete Rooms
        $Rooms = Room::all()->where('hall_id', $data->id);
        foreach ($Rooms as $student) {
            $student->delete();
        }
        //Delete Payments
        $Payments = Payment::all()->where('hall_id', $data->id);
        foreach ($Payments as $student) {
            $student->delete();
        }
        //Delete Histories
        $Histories = History::all()->where('hall_id', $data->id);
        foreach ($Histories as $student) {
            $student->delete();
        }
        //
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
