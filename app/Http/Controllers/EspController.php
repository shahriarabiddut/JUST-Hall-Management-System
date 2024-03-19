<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Hall;
use App\Models\MealToken;
use App\Models\HallOption;
use Illuminate\Http\Request;
use App\Models\TokenPrintQueue;

class EspController extends Controller
{
    //
    //post method
    public function TokenPrintQueue2(string $hall_id, string $value)
    {
        $hall = Hall::find($hall_id);
        dd($hall);
        if ($hall->enable_print == 0) {
            return 0;
        }
        if ($value != $hall->secret) {
            return 0;
        }

        $data = TokenPrintQueue::all()->where('hall_id', $hall_id);
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
    //Delete From Print Queue and Status Update
    public function TokenPrintQueueDelete2(string $hall_id, string $value, string $id, string $order_id, string $rollno)
    {
        $hall = Hall::find($hall_id);
        if ($hall->enable_print == 0) {
            return response()->json(0);
        }
        if ($value != $hall->secret) {
            return response()->json(0);
        }

        //Delete
        $data = TokenPrintQueue::all()->where('token_id', $id)->where('order_id', $order_id)->where('rollno', $rollno)->where('hall_id', $hall_id)->first();
        if ($data == null) {
            return response()->json(0);
        }
        $dataUpdate = MealToken::all()->where('id', '=', $id)->where('order_id', '=', $order_id)->where('rollno', '=', $rollno)->where('hall_id', $hall_id)->first();
        if ($dataUpdate == null) {
            return response()->json(0);
        }
        // Token Status Update
        $dataUpdate->print = 1;
        $dataUpdate->status = 4;
        $dataUpdate->save();
        //
        $data->delete();
        return response()->json(1);
    }
    public function qrcodescanesp(string $hall_id, string $value, string $tokenid)
    {
        function capitalizeAndLowercase($str)
        {
            $result = "";
            $len = strlen($str);
            for ($i = 0; $i < $len; $i++) {
                $char = $str[$i];
                if (ctype_lower($char)) {
                    $result .= strtoupper($char);
                } elseif (ctype_upper($char)) {
                    $result .= strtolower($char);
                } else {
                    $result .= $char;
                }
            }
            return $result;
        }
        // $result2 = capitalizeAndLowercase($tokenid);

        $hall = Hall::find($hall_id);
        if ($value != $hall->secret) {
            return 0;
        }
        //
        $data = MealToken::all()->where('token_number', $tokenid)->first();
        if ($data == null) {
            return 0;
        }
        if ($data->hall_id != $hall_id) {
            return 0;
        }
        //Check Date is Valid To Print
        $result = $this->isDateValid($data->date);
        if ($result == false) {
            return 0;
        }
        // Check Is Date Today
        $result2 = $this->isDateValid2($data->date);
        if ($result2 == false) {
            return 0;
        }
        //

        if ($data->meal_type == 'Lunch') {
            //If today time is greater than remaining time , Token Invalid
            $today = Carbon::now(); // get current date and time
            $remainingTime = $data->date . ' 16:00:00'; // Token Time
            $todayTime = $today->setTimezone('GMT+6')->format('Y-m-d H:i:s'); //Today Time

            if ($todayTime > $remainingTime) {
                return 0;
            }
            //
            //If Token invalid then falsecheck = 1 or update status as used
            if ($data->status == 1) {
                return 0;
            } else {
                $data->status = 1;
                $data->save();
            }

            // Updated
            return 1;
        } elseif ($data->meal_type == 'Suhr') {
            //If today time is greater than remaining time , Token Invalid
            $today = Carbon::now(); // get current date and time
            $remainingTime = $data->date . ' 4:00:00'; // Token Time
            $todayTime = $today->setTimezone('GMT+6')->format('Y-m-d H:i:s'); //Today Time

            if ($todayTime > $remainingTime) {
                return 0;
            }
            //
            //If Token invalid then falsecheck = 1 or update status as used
            if ($data->status == 1) {
                return 0;
            } else {
                $data->status = 1;
                $data->save();
            }

            // Updated
            return 1;
        } elseif ($data->meal_type == 'Dinner') {
            //If today time is greater than remaining time , Token Invalid
            $today = Carbon::now(); // get current date and time
            $remainingTime = $data->date . ' 23:59:00'; // Token Time
            $startofTime = $data->date . ' 18:59:00'; // Token Time
            $todayTime = $today->setTimezone('GMT+6')->format('Y-m-d H:i:s'); //Today Time

            if ($todayTime > $remainingTime) {
                return 0;
            }
            if ($todayTime < $startofTime) {
                return 0;
            }
            //If Token invalid then falsecheck = 1 or update status as used
            if ($data->status == 1) {
                return 0;
            } else {
                $data->status = 1;
                $data->save();
            }
            // Updated
            return 1;
        }
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
    public function isDateValid2(string $date)
    {
        //
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        $currentDate = $currentDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17

        $processedData = ($date == $currentDate);
        return $processedData;
    }
}
