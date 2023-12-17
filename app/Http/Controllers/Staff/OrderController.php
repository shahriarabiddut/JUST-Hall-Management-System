<?php

namespace App\Http\Controllers\Staff;

use App\Models\Food;
use App\Models\Order;
use App\Models\FoodTime;
use App\Models\MealToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TokenPrintQueue;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //
    public function index()
    {
        $data = Order::select('*')->orderBy("id", "desc")->where('food_item_id', '!=', '0')->get();
        $token = [];
        foreach ($data as $d) {
            $tokenData = MealToken::all()->where('order_id', '=', $d->id)->first();
            $token[] = $tokenData->status;
        }
        return view('staff.orders.index', ['data' => $data, 'token' => $token]);
    }
    public function searchByDate(Request $request)
    {
        $date = $request->date;
        $data = Order::all()->where('date', '=', $date);
        return view('staff.orders.search', ['data' => $data, 'date' => $date]);
    }
    public function searchByHistory(Request $request)
    {

        $date = $request->date;

        $resulttitle = [];

        $total_food_times = FoodTime::select('id')->get();
        $results = [];
        foreach ($total_food_times as $total_food_time) {
            $i = $total_food_time->id;
            $results[] = $this->foodTimeSearch($date, $i);
            $resulttitle[] = FoodTime::all()->where('id', '=', $i)->first();
        }


        return view('staff.orders.searchHistory', ['results' => $results, 'resulttitle' => $resulttitle, 'date' => $date]);
    }
    public function foodTime(string $nextDate, string $id)
    {
        //foodtype
        $food_time = FoodTime::all()->where('status', '=', '1')->where('id', '=', $id)->first();
        //Food Item for search
        $foods = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $id);
        $food_id_data = [];
        foreach ($foods as $food) {
            $food_id_data[] = $food->id;
        }
        // total count of foods for forloop
        $total_food_count = count($foods);
        $food_data = [];
        for ($i = 1; $i <= $total_food_count; $i++) {
            $food_item_id = $food_id_data[$i - 1];
            $food_data[$i] = Order::where('date', '=', $nextDate)
                ->where('order_type', '=', $food_time->title)
                ->where('food_item_id', '=', $food_item_id)->sum('quantity');
        }

        return [$food_data, $foods];
    }
    public function foodTimeSearch(string $nextDate, string $id)
    {
        //foodtype
        $food_time = FoodTime::all()->where('id', '=', $id)->first();
        //Food Item for search
        $foods = Food::all()->where('food_time_id', '=', $id);
        $food_id_data = [];
        foreach ($foods as $food) {
            $food_id_data[] = $food->id;
        }
        // total count of foods for forloop
        $total_food_count = count($foods);
        $food_data = [];
        for ($i = 1; $i <= $total_food_count; $i++) {
            $food_item_id = $food_id_data[$i - 1];
            $food_data[$i] = Order::where('date', '=', $nextDate)
                ->where('order_type', '=', $food_time->title)
                ->where('food_item_id', '=', $food_item_id)->sum('quantity');
        }

        return [$food_data, $foods];
    }
    public function show(string $id)
    {
        //
        $data = MealToken::all()->where('order_id', '=', $id)->first();
        $data2 = Order::all()->where('id', '=', $data->order_id)->first();
        $currentDate = Carbon::now(); // get current date and time
        $current_time = $currentDate->setTimezone('GMT+6')->format('Y-m-d');
        if ($data->status != 1) {
            if ($current_time == $data2->date) {
                $messageExtra = 'Meal Token Valid & Please Serve';
                $bg = 'bg-success';
                return view('staff.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
            } else if ($current_time < $data2->date) {
                $messageExtra = "Meal Token Valid on : " . $data2->date;
                $bg = 'bg-info';
                return view('staff.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
            } else {
                $messageExtra = 'Time Passed & Meal Cannot Be Served';
                $bg = 'bg-danger';
                return view('staff.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
            }
        } else {
            $messageExtra = ' Meal Token Allready Used';
            $bg = 'bg-warning';
            return view('staff.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
        }
    }
    public function update(string $id)
    {
        //
        $data = MealToken::find($id);
        if ($data->status >= 1) {
            return redirect()->back()->with('danger', 'Warning!');
        } else {
            $data->status = 1;
            $data->save();
            return redirect()->back()->with('success', 'Token is Marked as Used Successfully!');
        }
    }
    //ESP 32
    public function printNet(string $id)
    {
        //
        $data = MealToken::all()->where('order_id', '=', $id)->first();
        //Check Date is Valid To Print
        $result = $this->isDateValid($data->date);
        if ($result != 'true') {
            return redirect()->route('staff.orders.index')->with('danger', 'Token Expired!');
        }
        if ($data == null) {
            return redirect()->back();
        }
        // Done
        if ($data->status == 0) {
            // Token Status Update
            $data->status = 3;
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
                $newdata->save();
                //Change Status to 1
                // Update Token Status
                //
                return redirect()->route('staff.orders.index')->with('success', 'Token On Print Queue!');
            } else {
                return redirect()->route('staff.orders.index')->with('danger', 'Token is Allready on Print Queue!');
            }
        } elseif ($data->status == 3) {
            return redirect()->route('staff.orders.index')->with('danger', 'Token is on Print Queue!');
        } else {
            return redirect()->route('staff.orders.index')->with('danger', 'Ops! Token Expired!');
        }
    }

    public function TokenPrintQueue()
    {
        $data = TokenPrintQueue::all();
        $dataTokenPrintQueue = '';
        foreach ($data as $key => $d) {
            if ($key >= 0 && $key < count($data) - 1) {
                $dataTokenPrintQueue = $dataTokenPrintQueue . $d->data . ',';
            } else {
                $dataTokenPrintQueue = $dataTokenPrintQueue . $d->data;
            }
        }
        // return response($d->data);
        return response($dataTokenPrintQueue);
    }
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
