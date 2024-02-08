<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Food;
use App\Models\Order;
use App\Models\FoodTime;
use App\Models\MealToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userid = Auth::user()->id;
        $data = Order::select('*')->where('student_id', '=', $userid)->where('food_item_id', '!=', 0)->orderBy("date", "desc")->get();
        return view('profile.order.index', ['data' => $data]);
    }
    public function foodmenu()
    {
        //If remaining time is 0 , Student cannot order
        $today = Carbon::now(); // get current date and time
        $remainingTime = $today->setTimezone('GMT+6')->format('Y-m-d') . ' 22:00:00';
        $todayTime = $today->setTimezone('GMT+6')->format('Y-m-d H:i:s'); // 2023-03-17
        if ($remainingTime < $todayTime) {
            $remainingTime = 0;
        }
        //
        $dataFoodTime = FoodTime::all()->where('status', '=', '1');
        $FoodTime = [];
        foreach ($dataFoodTime as $dFT) {
            $FoodTime[] = $dFT;
        }
        $foods = [];
        foreach ($FoodTime as $ft) {
            $dataFoodTime = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $ft->id);
            $foods[] = $dataFoodTime;
        }


        return view('profile.order.fooditem', ['FoodTime' => $FoodTime, 'foods' => $foods, 'remainingTime' => $remainingTime]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOrder(string $id)
    {
        $userid = Auth::user()->id;
        // Check If User Ballance is less then 50
        $this->checkBalance($userid);
        //Check Food Time exist or not
        $food_time_id = $id;
        $food_time = FoodTime::all()->where('status', '=', '1')->where('id', '=', $food_time_id)->first();
        if ($food_time == null) {
            return redirect()->route('student.order.index')->with('danger', 'Not Found');
        }
        //checking if its tommorow 
        $currentDate = Carbon::now(); // get current date and time
        $current_time = $currentDate->setTimezone('GMT+6')->format('H:i:s'); // "00:10:15"
        //Suhr 2 days 
        if ($food_time_id == 3) {
            $nextDate2 = $currentDate->addDay(); // add one day to current date
            $nextDate = $nextDate2->addDay(); // add one day to current date
        } else {
            // Launch and Dinner 1 Day
            $nextDate = $currentDate->addDay(); // add one day to current date
        }
        //
        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
        //check on that day student has how many order
        $data = Order::where('date', '=', $nextDate)
            ->where('order_type', '=', $food_time->title)
            ->where('student_id', '=', $userid)
            ->count();
        //check on that day student order quantity
        if ($data == 0) {
            $dataquantity = 0;
        } elseif ($data >= 2) {
            $dataquantity = 2;
            return redirect()->route('student.order.foodmenu')->with('danger', 'You have allready ordered maximum  ' . $nextDate . ' for ' . $food_time->title);
        } else {
            // Checking How many food ordered in a Single order
            $data_quantity = Order::all()->where('date', '=', $nextDate)
                ->where('order_type', '=', $food_time->title)
                ->where('student_id', '=', $userid)->first();
            $dataquantity  =   $data_quantity->quantity;
        }
        if (!$data) {
            //check time if it is less then 10 PM
            if ($current_time < "22:00:00") {
                if ($food_time != null) {
                    $food = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $food_time_id);
                    return view('profile.order.create', ['food_time' => $food_time, 'food' => $food, 'nextDate' => $nextDate]);
                } else {
                    return redirect()->route('student.order.foodmenu')->with('danger', 'Select Valid Food Menu');
                }
            } else {
                return redirect()->route('student.order.foodmenu')->with('danger', 'Order Time has finished! You can place order Tommorow again!');
            }
        } elseif ($dataquantity < 2) {
            //check time if it is less then 10 PM
            if ($current_time < "22:00:00") {
                if ($food_time != null) {
                    $food = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $food_time_id);
                    return view('profile.order.create', ['food_time' => $food_time, 'food' => $food, 'dataquantity' => $dataquantity, 'nextDate' => $nextDate]);
                } else {
                    return redirect()->route('student.order.foodmenu')->with('danger', 'Select Valid Food Menu');
                }
            } else {
                return redirect()->route('student.order.foodmenu')->with('danger', 'Order Time has finished! You can place order Tommorow again!');
            }
        } else {
            return redirect()->route('student.order.foodmenu')->with('danger', 'You have allready ordered maximum on that day ' . $nextDate . ' for ' . $food_time->title);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userid = Auth::user()->id;
        // Checks Balance
        $dataBalance = Balance::Find($userid);
        if ($dataBalance->balance_amount <= 50) {
            return redirect()->route('student.balance.index')->with('danger', 'Please! Add Balance First.');
        }
        //
        if ($request->food_item_id == 0) {
            return redirect()->back()->with('danger', 'Please!Select A Food !');
        } elseif ($request->quantity == 0) {
            return redirect()->back()->with('danger', 'Please! Select Quantity!');
        } else {
            $food_time_id = $request->food_time_id;
            $foodprice = FoodTime::all()->where('status', '=', '1')->where('id', '=', $food_time_id)->first();
            $request->validate([
                'order_type' => 'required',
                'food_item_id' => 'required',
                'quantity' => 'required',
            ]);
            $data = new Order;
            $data->student_id = $userid;
            $data->order_type = $request->order_type;
            $data->food_item_id = $request->food_item_id;
            $data->quantity = $request->quantity;
            $data->price = $foodprice->price * $data->quantity;
            $data->date = $request->date;

            $givendate = $data->date;
            //Suhr Ectra Rule
            if ($food_time_id == 3) {
                $result = $this->isItTommorowSuhr($givendate);
            } else {
                $result = $this->isItTommorow($givendate);
            }
            //Suhr Ectra Rule
            if ($result) {

                $data->save();
                $dataPrice = $data->price;
                // Deduct From Balance
                $this->deductBalance($userid, $dataPrice);
                //Generating Meal Token
                $MealTokenController = new MealTokenController();
                $MealTokenController->generateTokenAuto($data->id);
            } else {
                return redirect()->route('student.order.index')->with('danger', 'Please! Select Correct Date');
            }

            return redirect()->route('student.order.index')->with('success', 'Meal Order placed Successfully And Token Generated Successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function checkBalance(string $userid)
    {
        //
        $data = Balance::Find($userid);
        if ($data->balance_amount <= 50) {
            return redirect()->route('student.balance.index')->with('danger', 'Please! Add Balance First.');
        } else {
            return $data->balance_amount;
        }
    }
    public function isItTommorow(string $id)
    {
        //
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17

        $processedData = $id == $nextDate;
        return $processedData;
    }
    public function isItTommorowSuhr(string $id)
    {
        //
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        $nextDate2 = $currentDate->addDay(); // add one day to current date
        $nextDate = $nextDate2->addDay(); // add one day to current date
        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17

        $processedData = $id == $nextDate;
        return $processedData;
    }
    // Deduct balance if order is placed
    public function deductBalance(string $userid, string $dataPrice)
    {
        // Deduct From Balance
        $dataBalance = Balance::Find($userid);
        if ($dataBalance != null) {
            $dataBalanceAmount = $dataBalance->balance_amount;
            $dataBalanceAmount = $dataBalanceAmount - $dataPrice;

            //Deducing Balance
            $dataBalance->balance_amount = $dataBalanceAmount;
            $dataBalance->save();
        } else {
            return redirect('student/order')->with('danger', 'Please! Add Balance First');
        }
    }
    public function show(string $id)
    {
        //
        $data = Order::all()->where('id', '=', $id)->first();
        $foodItem = Food::all()->where('id', '=', $data->food_item_id)->first();
        if ($data == null) {
            return redirect()->route('student.order.index')->with('danger', 'Not Found');
        }
        $tokendata = MealToken::all()->where('order_id', '=', $id)->first();
        //Check Date is Valid To Delete
        $validDate = $this->isDateValid2Cancel($data->date, $foodItem->food_time_id);

        //
        return view('profile.order.show', ['data' => $data, 'tokendata' => $tokendata, 'validDate' => $validDate]);
    }
    public function isDateValid(string $date)
    {
        //
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
        $processedData = ($date > $nextDate);
        return $processedData;
    }
    public function isDateValid2Cancel(string $date, string $food_time_id)
    {
        //
        $currentDate = Carbon::now(); // get current date and time
        //
        $TokenDate = $date; // Token Date
        //
        //Suhr 2 days 
        if ($food_time_id == 3) {
            // $TokenDate = Carbon::createFromFormat('Y-m-d', $date); // Token Date
            // $TokenDate = $TokenDate->addDay();
            // $TokenDate = $TokenDate->toDateString();
            $nextDate2 = $currentDate->addDay();
            $nextDate = $nextDate2->addDay();
        } else {
            $nextDate = $currentDate->addDay(); // add one day to current date
        }
        //
        $TokenTime = $TokenDate . ' 22:00:00'; // Token Time to Delete 10 PM
        //
        $nextDateData = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // add one day to current date
        $currentTime = $nextDate->setTimezone('GMT+6')->format('Y-m-d H:i:s'); // 2023-03-17
        //
        $processedDate = ($TokenDate >= $nextDateData);
        // dd($processedDate, $TokenDate, $nextDateData);
        if (($processedDate)) {
            $processedData = ($currentTime < $TokenTime);
            // dd($processedData, $currentTime, $TokenTime);
            return $processedData;
        } else {
            return $processedDate;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $currentDate = Carbon::now(); // get current date and time
        $current_Date = $currentDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
        $current_time = $currentDate->setTimezone('GMT+6')->format('H:i:s'); // "00:10:15"
        $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
        $data = Order::all()->where('id', '=', $id)->first();

        if ($data->date <= $nextDate) {
            return redirect('student/order')->with('danger', 'You cannot edit anymore for this Order!Day Passed!');
        } else {
            if ($current_time < "22:00:00") {
                $foodItem = Food::all()->where('id', '=', $data->food_item_id)->first();
                $foods = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $foodItem->food_time_id);
                return view('profile.order.edit', ['data' => $data, 'foods' => $foods]);
            } else {
                return redirect('student/order')->with('danger', 'You cannot edit anymore for this Order! Time Passed!');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        if ($request->food_item_id == 0) {
            return redirect()->back()->with('danger', 'Please!Select A Food !');
        } else {
            $request->validate([
                'food_item_id' => 'required',
            ]);

            $data = Order::all()->where('id', '=', $id)->first();

            $data->food_item_id = $request->food_item_id;
            $data->save();
            //Update in Meal Token
            $food = Food::all()->where('id', '=', $request->food_item_id)->first();
            $data2 = MealToken::all()->where('order_id', '=', $id)->first();
            $data2->food_name = $food->food_name;
            $data2->save();
            //Updated
            return redirect('student/order')->with('success', 'Meal Order updated Successfully!');
        }
    }
    public function searchByDate(Request $request)
    {
        $userid = Auth::user()->id;
        $date = $request->date;
        $data = Order::all()->where('date', '=', $date)->where('student_id', '=', $userid);
        return view('profile.order.search', ['data' => $data, 'date' => $date]);
    }
    public function searchByMonth(Request $request)
    {
        $userid = Auth::user()->id;
        $dataMo = [];
        foreach (explode('-', $request->month) as $dataMonth) {
            $dataMo[] = $dataMonth;
        }
        $year = $dataMo[0]; // Replace with the year you want to search for
        $month = $dataMo[1];   // Replace with the month you want to search for
        $SearchData = $request->month;   // Replace with the month you want to search for

        $data = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('student_id', '=', $userid)
            ->get();
        $sumofthatmonth = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('student_id', '=', $userid)
            ->sum('price');

        return view('profile.order.searchMonth', ['data' => $data, 'month' => $SearchData, 'sumofthatmonth' => $sumofthatmonth]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Id 
        $userid = Auth::user()->id;
        //
        $data = Order::all()->where('id', '=', $id)->first();
        $foodItem = Food::all()->where('id', '=', $data->food_item_id)->first();
        if ($data == null) {
            return redirect()->route('student.order.index')->with('danger', 'Not Found');
        }
        //Check Date is Valid To Delete
        $validDate = $this->isDateValid2Cancel($data->date, $foodItem->food_time_id);
        //
        if (!$validDate) {
            return redirect('student/order')->with('danger', 'You cannot edit anymore for this Order!Day Passed!');
        } else {
            //Food Price
            $dataPrice = $data->price;
            //Add Deducted Balance
            $this->AddBalance($userid, $dataPrice);
            //Meal Token Delete
            $MealToken = MealToken::all()->where('order_id', '=', $id)->first();
            $MealToken->delete();
            //Order Delete
            $data->delete();
            return redirect()->route('student.order.index')->with('success', 'Order Deleted!');
        }
    }
    //Add Balance
    public function AddBalance(string $userid, string $dataPrice)
    {
        // Deduct From Balance
        $dataBalance = Balance::Find($userid);
        if ($dataBalance != null) {
            $dataBalanceAmount = $dataBalance->balance_amount;
            $dataBalanceAmount = $dataBalanceAmount + $dataPrice;

            //Deducing Balance
            $dataBalance->balance_amount = $dataBalanceAmount;
            $dataBalance->save();
        } else {
            return redirect('student/order')->with('danger', 'Please! Add Balance First');
        }
    }
    /**
     * Show the form for creating a new Advance Order.
     */
    public function createOrderAdvance(string $id)
    {
        //
        $currentDate = Carbon::now(); // get current date and time
        $current_Date = $currentDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
        $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate2 = $nextDate->addDay(); // add one day to current date
        $nextDate3 = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
        //
        $userid = Auth::user()->id;
        // Checks Balance
        $dataBalance = Balance::Find($userid);
        if ($dataBalance->balance_amount <= 50) {
            return redirect()->route('student.balance.index')->with('danger', 'Please! Add Balance First.');
        }
        //
        $food_time_id = $id;
        $food_time = FoodTime::all()->where('status', '=', '1')->where('id', '=', $food_time_id)->first();
        if ($food_time != null) {
            $food = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $food_time_id);
            return view('profile.order.createAdvance', ['food_time' => $food_time, 'food' => $food, 'nextDate' => $nextDate3]);
        } else {
            return redirect()->route('student.order.foodmenu')->with('danger', 'Select Valid Food Menu');
        }
    }
    public function storeOrderAdvance(Request $request)
    {
        $userid = Auth::user()->id;
        // Checks Balance
        $dataBalance = Balance::Find($userid);
        if ($dataBalance->balance_amount <= 50) {
            return redirect()->route('student.balance.index')->with('danger', 'Please! Add Balance First.');
        }
        //
        $request->validate([
            'order_type' => 'required',
            'food_item_id' => 'required',
            'quantity' => 'required',
            'student_id' => 'required',
        ]);
        $userid = $request->student_id;
        $advanceDate = $request->date;
        $food_time_id = $request->food_time_id;
        $food_time = FoodTime::all()->where('status', '=', '1')->where('id', '=', $food_time_id)->first();
        if ($request->food_item_id == 0) {
            return redirect()->back()->with('danger', 'Please!Select A Food !');
        } elseif ($request->quantity == 0) {
            return redirect()->back()->with('danger', 'Please! Select Quantity!');
        } else {
            //check on that day student has how many order
            $advanceData = Order::where('date', '=', $advanceDate)
                ->where('order_type', '=', $food_time->title)
                ->where('student_id', '=', $userid)
                ->count();
            //check on that day student order quantity
            if ($advanceData == 0) {
                $dataquantity = 0;
            } elseif ($advanceData >= 2) {
                $dataquantity = 2;
                return redirect()->route('student.order.foodmenu')->with('danger', 'You have allready ordered maximum  ' . $advanceDate . ' for ' . $food_time->title);
            } else {
                // Checking How many food ordered in a Single order
                $data_quantity = Order::all()->where('date', '=', $advanceDate)
                    ->where('order_type', '=', $food_time->title)
                    ->where('student_id', '=', $userid)->first();
                $dataquantity  =   $data_quantity->quantity;
            }
            //
            if ($dataquantity < 2) {

                $food_time_id = $request->food_time_id;
                $foodprice = FoodTime::all()->where('status', '=', '1')->where('id', '=', $food_time_id)->first();
                $data = new Order;
                $userid = Auth::user()->id;
                $data->student_id = $userid;
                $data->order_type = $request->order_type;
                $data->food_item_id = $request->food_item_id;

                //Setting Quantity for security
                $order_quantity = $request->quantity;
                if ($dataquantity == 1) {
                    $order_quantity = 1;
                }
                $data->quantity = $order_quantity;
                // Quantity
                $data->price = $foodprice->price * $data->quantity;
                $data->date = $request->date;
                $data->save();

                $dataPrice = $data->price;
                // Deduct From Balance
                $this->deductBalance($userid, $dataPrice);
                //Generating Meal Token
                $MealTokenController = new MealTokenController();
                $MealTokenController->generateTokenAuto($data->id);


                return redirect()->route('student.order.index')->with('success', 'Advance Meal Order placed Successfully for ' . $advanceDate . ' And Token Generated Successfully!');
            } else {
                return redirect()->route('student.order.foodmenu')->with('danger', 'You have allready ordered maximum  ' . $advanceDate . ' for ' . $food_time->title);
            }
        }
    }
}
