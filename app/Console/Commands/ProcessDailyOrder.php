<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Order;
use App\Models\Balance;
use App\Models\Student;
use Illuminate\Console\Command;
use App\Http\Controllers\MealTokenController;
use App\Http\Controllers\OrderController;

class ProcessDailyOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-daily-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //Controllers
        $MealTokenController = new MealTokenController();
        $OrderTokenController = new OrderController();
        //
        $currentDay = date('w');
        //$currentDayNumeric = ($currentDay == 6) ? 1 : $currentDay + 2;
        $nextDay = ($currentDay == 6) ? 1 : $currentDay + 3;
        $users = Student::all();
        foreach ($users as $user) {
            if ($user->autoOrder != null) {
                $orders = json_decode($user->autoOrder->orders, true);
                // Checks Balance
                $dataBalance = Balance::all()->where('student_id', $user->id)->first();
                //Lunch
                if ($dataBalance->balance_amount >= 50) {
                    $oFood = $nextDay;
                    $food_item = Food::find($orders[$oFood]);
                    if ($food_item->status != 0 && $food_item->food_time_hall->status != 0) {
                        $currentDate = Carbon::now();
                        $nextDate = $currentDate->addDay();
                        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
                        //check on that day student has how many order
                        $data = Order::where('date', '=', $nextDate)
                            ->where('order_type', '=', 'Lunch')
                            ->where('student_id', '=', $user->id)
                            ->count();
                        //check on that day student order quantity
                        if ($data == 0) {
                            $data = new Order;
                            $data->student_id = $user->id;
                            $data->order_type = 'Lunch';
                            $data->food_item_id = $food_item->id;
                            $data->quantity = 1;
                            $data->price = $food_item->food_time_hall->price;
                            $data->date = $nextDate;
                            $data->hall_id = $user->hall_id;
                            $data->save();
                            $dataPrice = $data->price;
                            // Deduct From Balance
                            $OrderTokenController->deductBalance($user->id, $dataPrice);
                            //Generating Meal Token
                            $MealTokenController->generateTokenAuto($data->id, $data->hall_id);
                        }
                    }
                }
                //Dinner
                if ($dataBalance->balance_amount >= 50) {
                    $oFood = $nextDay + 7;
                    $food_item = Food::find($orders[$oFood]);
                    if ($food_item->status != 0 && $food_item->food_time_hall->status != 0) {
                        $currentDate = Carbon::now();
                        $nextDate = $currentDate->addDay();
                        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
                        //check on that day student has how many order
                        $data = Order::where('date', '=', $nextDate)
                            ->where('order_type', '=', 'Dinner')
                            ->where('student_id', '=', $user->id)
                            ->count();
                        //check on that day student order quantity
                        if ($data == 0) {
                            $data = new Order;
                            $data->student_id = $user->id;
                            $data->order_type = 'Dinner';
                            $data->food_item_id = $food_item->id;
                            $data->quantity = 1;
                            $data->price = $food_item->food_time_hall->price;
                            $data->date = $nextDate;
                            $data->hall_id = $user->hall_id;
                            $data->save();
                            $dataPrice = $data->price;
                            // Deduct From Balance
                            $OrderTokenController->deductBalance($user->id, $dataPrice);
                            //Generating Meal Token
                            $MealTokenController->generateTokenAuto($data->id, $data->hall_id);
                        }
                    }
                }
            }
        }
    }
}
