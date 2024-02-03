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
    public function generateTokenAuto(string $id)
    {
        //
        $data = Order::all()->where('id', '=', $id)->first();
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
        if ($data) {
            $link = route('staff.orders.show', $data->order_id);
            $qrcode = 0;
            return view('profile.mealtoken.show', ['data' => $data, 'qrcode' => $qrcode]);
        } else {
            return redirect('student/mealtoken')->with('danger', ' Generate Mealtoken First!');
        }
    }
    public function showbyorder(string $id)
    {
        //
        $data = MealToken::all()->where('order_id', '=', $id)->first();
        if ($data) {
            $link = route('staff.orders.show', $data->order_id);
            // $qrcode = QrCode::size(300)->generate($link);
            $qrcode = 0;
            return view('profile.mealtoken.show', ['data' => $data, 'qrcode' => $qrcode]);
        } else {
            return redirect('student/mealtoken')->with('danger', ' Generate Mealtoken First!');
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
            return redirect()->route('student.mealtoken.index')->with('danger', 'Token Expired!');
        }
        if ($data == null) {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Error!');
        }
        if ($data->print >= 1) {
            return redirect()->route('student.mealtoken.index')->with('danger', 'You can not print anymore!');
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
                $newdata->save();
                //Change Status to 1
                // Update Token Status
                //
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
    //post method
    public function TokenPrintQueue2(string $value1)
    {
        $printingOption = HallOption::all()->where('id', '10')->first();

        if ($value1 != $printingOption->value) {
            return redirect()->route('root')->with('danger', 'Ops! Token Expired!');
        }
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
    //
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
    //Delete From Print Queue
    public function TokenPrintQueueDelete(string $id, string $order_id, string $rollno)
    {
        // Token Status Update
        $dataUpdate = MealToken::all()->where('id', '=', $id)->where('order_id', '=', $order_id)->where('rollno', '=', $rollno)->first();
        if ($dataUpdate == null) {
            return response()->json(0);
        }
        // $dataUpdate->status = 1;
        // $dataUpdate->save();
        //Delete
        $data = TokenPrintQueue::all()->where('token_id', '=', $id)->where('order_id', '=', $order_id)->where('rollno', '=', $rollno)->first();
        if ($data == null) {
            return response()->json(0);
        }
        $data->delete();
        return response()->json(1);
    }
    public function TokenPrintQueueDelete2(string $value, string $id, string $order_id, string $rollno)
    {
        $printingOption = HallOption::all()->where('id', '10')->first();

        if ($value != $printingOption->value) {
            return redirect()->route('root')->with('danger', 'Ops! Token Expired!');
        }
        // Token Status Update
        $dataUpdate = MealToken::all()->where('id', '=', $id)->where('order_id', '=', $order_id)->where('rollno', '=', $rollno)->first();
        if ($dataUpdate == null) {
            return response()->json(0);
        }
        $dataUpdate->print = 1;
        $dataUpdate->save();
        //Delete
        $data = TokenPrintQueue::all()->where('token_id', '=', $id)->where('order_id', '=', $order_id)->where('rollno', '=', $rollno)->first();
        if ($data == null) {
            return response()->json(0);
        }
        $data->delete();
        return response()->json(1);
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
