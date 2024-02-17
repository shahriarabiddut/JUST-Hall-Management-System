<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Order;
use App\Models\MealToken;
use App\Models\TokenPrintQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\HallOption;

class MealTokenController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('student.dashboard')->with('danger', 'Please Get Hall Room Allocation to get access!');
            }
            if (Auth::user()->hall->status == 0) {
                return redirect()->route('student.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userid = Auth::user()->rollno;
        $data = MealToken::select('*')->where('rollno', '=', $userid)->orderBy("id", "desc")->get();
        return view('profile.mealtoken.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generate(string $id)
    {
        //
        $data = Order::all()->where('id', '=', $id)->first();
        $foodname = Food::all()->where('id', '=', $data->food_item_id)->first();
        $newdata = new MealToken;
        $newdata->food_name = $foodname->food_name;
        $newdata->token_number = bcrypt($id);
        $newdata->date = $data->date;
        $newdata->rollno = Auth::user()->rollno;
        $newdata->status = 0;
        $newdata->quantity = $data->quantity;
        $newdata->order_id = $id;
        $newdata->meal_type = $data->order_type;
        $newdata->save();
        return redirect('student/mealtoken')->with('success', 'Mealtoken Generated Successfully!');
    }
    public function generateTokenAuto(string $id, string $hall_id)
    {
        //
        $data = Order::find($id);
        $foodname = Food::all()->where('id', '=', $data->food_item_id)->first();

        $newdata = new MealToken;
        $newdata->food_name = $foodname->food_name;
        $newdata->date = $data->date;
        $newdata->token_number = bcrypt($id);
        $newdata->rollno = Auth::user()->rollno;
        $newdata->status = 0;
        $newdata->quantity = $data->quantity;
        $newdata->order_id = $id;
        $newdata->meal_type = $data->order_type;
        $newdata->hall_id = $hall_id;
        $newdata->save();
        return $newdata->id;
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = MealToken::find($id);
        if ($data == null) {
            return redirect()->route('student.order.index')->with('danger', ' Not Found!');
        }
        if ($data->rollno != Auth::user()->rollno) {
            return redirect()->route('student.dashboard')->with('danger', ' Unauthorized Access!');
        }
        if ($data) {
            return view('profile.mealtoken.show', ['data' => $data]);
        } else {
            return redirect('student/mealtoken')->with('danger', ' Generate Mealtoken First!');
        }
    }
    public function showbyorder(string $id)
    {
        //
        $data = MealToken::all()->where('order_id', '=', $id)->first();
        if ($data == null) {
            return redirect()->route('student.order.index')->with('danger', ' Not Found!');
        }
        if ($data->rollno != Auth::user()->rollno) {
            return redirect()->route('student.dashboard')->with('danger', ' Unauthorized Access!');
        }
        if ($data) {
            return view('profile.mealtoken.show', ['data' => $data]);
        } else {
            return redirect('student/mealtoken')->with('danger', ' Generate Mealtoken First!');
        }
    }
    //ESP 32
    public function printNet(string $id)
    {
        $userid = Auth::user()->id;
        //
        $data = MealToken::all()->where('order_id', '=', $id)->first();
        $data2 = Order::find($id);
        if ($data == null || $data2 == null) {
            return redirect()->route('student.order.index')->with('danger', 'Not Found');
        }
        if ($data2->student_id != $userid) {
            return redirect()->route('student.dashboard')->with('danger', ' Unauthorized Access!');
        }
        //Check Date is Valid To Print
        $result = $this->isDateValid($data->date);
        if ($result != 'true') {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Token Expired!');
        }
        if ($data == null) {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Error!');
        }
        if ($data->print >= 1) {
            return redirect()->route('student.mealtoken.index')->with('danger', "You can't print anymore!");
        }
        // Done
        if ($data->status == 0) {
            // Token Status Update
            $data->status = 3;
            $data->print = 1;
            $data->save();
            //Check if printqueue Exist
            $printqueue = TokenPrintQueue::all()->where('id', '=', $data->id)->first();
            if ($printqueue == null) {
                // Add On Print Queue
                $newdata = new TokenPrintQueue();
                $newdata->token_id = $data->id;
                $newdata->order_id = $data->order_id;
                $newdata->rollno = $data->rollno;
                $newdata->data = $data;
                $newdata->hall_id = $data->hall_id;
                $newdata->save();
                return redirect()->route('student.mealtoken.index')->with('success', 'Token On Print Queue!');
            } else {
                return redirect()->route('student.mealtoken.index')->with('danger', 'Token is Allready on Print Queue!');
            }
        } elseif ($data->status == 3) {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Token is on Print Queue!');
        } else {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Ops! Token Expired!');
        }
    }

    //
    public function isDateValid(string $date)
    {
        //
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        $currentDate = $currentDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17

        $processedData = ($date >= $currentDate);
        return $processedData;
    }
}
