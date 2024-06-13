<?php

namespace App\Http\Controllers\Admin;

use App\Models\Food;
use App\Models\Hall;
use App\Models\Order;
use App\Models\FoodTime;
use App\Models\MealToken;
use App\Models\FoodTimeHall;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //
    public function index()
    {
        $data = Order::select('*')->orderBy("id", "desc")->where('food_item_id', '!=', '0')->get();
        $halls = Hall::all();
        $token = [];
        foreach ($data as $d) {
            $tokenData = MealToken::all()->where('order_id', '=', $d->id)->first();
            $token[] = $tokenData->status;
        }
        $dataFoodTime = FoodTime::all();
        return view('admin.orders.index', ['data' => $data, 'token' => $token, 'halls' => $halls, 'dataFoodTime' => $dataFoodTime]);
    }
    public function searchByDate(Request $request)
    {
        if ($request->hall_id == 0) {
            return redirect()->back()->with('danger', 'Please Select Hall!');
        }
        $date = $request->date;
        $type = $request->type;
        $hall_id = $request->hall_id;
        $data = Order::all()->where('hall_id', $hall_id);
        if ($date != null) {
            $data = $data->where('date', $date);
        }
        if ($type != '' && $type != 'x') {
            $data = $data->where('order_type', $type);
        }

        $dataFoodTime = FoodTime::all();
        $halls = Hall::all();
        return view('admin.orders.search', ['data' => $data, 'date' => $date, 'type' => $type, 'hall_id' => $hall_id, 'dataFoodTime' => $dataFoodTime, 'halls' => $halls]);
    }
    public function searchByHistory(Request $request)
    {
        if ($request->hall_id == 0) {
            return redirect()->back()->with('danger', 'Please Select Hall!');
        }
        $date = $request->date;
        $resulttitle = [];
        $dataFoodTime = FoodTimeHall::all()->where('status', '1')->where('hall_id', $request->hall_id);
        $total_food_times = [];
        foreach ($dataFoodTime as $dFT) {
            $total_food_times[] = FoodTime::find($dFT->food_time_id);
        }
        $results = [];
        foreach ($total_food_times as $total_food_time) {
            $food_time_id = $total_food_time->id;
            $results[] = $this->foodTimeSearch($date, $food_time_id, $request->hall_id);
            $resulttitle[] = FoodTime::find($food_time_id);
        }
        $halls = Hall::all();
        return view('admin.orders.searchHistory', ['results' => $results, 'resulttitle' => $resulttitle, 'date' => $date, 'hall_id' => $request->hall_id, 'halls' => $halls]);
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
    public function foodTimeSearch(string $nextDate, string $id, string $hall_id)
    {
        //foodtype
        $food_time = FoodTime::all()->where('id', '=', $id)->first();
        //Food Item for search
        $foods = Food::all()->where('food_time_id', '=', $id)->where('hall_id', $hall_id);
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
                ->where('food_item_id', '=', $food_item_id)->where('hall_id', $hall_id)->sum('quantity');
        }

        return [$food_data, $foods];
    }
    public function show(string $id)
    {
        //
        $data = MealToken::all()->where('order_id', '=', $id)->first();
        if ($data == null) {
            return redirect()->route('admin.orders.index')->with('danger', 'Not Found!');
        }
        $data2 = Order::all()->where('id', '=', $data->order_id)->first();
        $currentDate = Carbon::now(); // get current date and time
        $current_time = $currentDate->setTimezone('GMT+6')->format('Y-m-d');
        if ($data->status != 1) {
            if ($current_time == $data2->date) {
                $messageExtra = 'Meal Token Valid & Please Serve';
                $bg = 'bg-success';
                return view('admin.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
            } else if ($current_time < $data2->date) {
                $messageExtra = "Meal Token Valid on : " . $data2->date;
                $bg = 'bg-info';
                return view('admin.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
            } else {
                $messageExtra = 'Time Passed & Meal Cannot Be Served';
                $bg = 'bg-danger';
                return view('admin.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
            }
        } else {
            $messageExtra = ' Meal Token Allready Used';
            $bg = 'bg-warning';
            return view('admin.orders.show', ['data' => $data, 'messageExtra' => $messageExtra, 'bg' => $bg]);
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
    //Print meal token

}
