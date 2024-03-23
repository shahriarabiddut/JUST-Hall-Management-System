<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Order;
use App\Models\Balance;
use App\Models\Student;
use App\Models\FoodTimeHall;
use Illuminate\Console\Command;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MealTokenController;

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
                if ($user->autoOrder->status != 0) {
                    $orders = json_decode($user->autoOrder->orders, true);
                    // Checks Balance
                    $dataBalance = Balance::all()->where('student_id', $user->id)->first();
                    $oLunch = $nextDay;
                    $oDinner = $nextDay + 7;
                    //Lunch
                    if ($dataBalance->balance_amount >= 50 && $orders[$oLunch] != 0) {
                        $food_item = Food::find($orders[$oLunch]);
                        if ($food_item->status != 0 && $food_item->food_time_hall->status != 0) {
                            $currentDate = Carbon::now();
                            $nextDate = $currentDate->addDay();
                            $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
                            //check on that day student has how many order
                            $data = Order::where('date', '=', $nextDate)
                                ->where('order_type', '=', 'Lunch')
                                ->where('student_id', '=', $user->id)
                                ->count();
                            $FoodTimeHallData = FoodTimeHall::all()->where('food_time_id', '=', $food_item->food_time_id)->where('hall_id', $user->hall_id)->first();
                            $dataPrice = $food_item->price;
                            //check on that day student order quantity
                            if ($data == 0 && $food_item->status != 0 && $FoodTimeHallData->status != 0 && $dataPrice < $dataBalance->balance_amount) {
                                $data = new Order;
                                $data->student_id = $user->id;
                                $data->order_type = 'Lunch';
                                $data->food_item_id = $food_item->id;
                                $data->quantity = 1;
                                $data->price = $dataPrice;
                                $data->date = $nextDate;
                                $data->hall_id = $user->hall_id;
                                $data->save();
                                // Deduct From Balance
                                $OrderTokenController->deductBalance($user->id, $dataPrice);
                                //Generating Meal Token
                                $MealTokenController->generateTokenAuto($data->id, $data->hall_id);
                            }
                        }
                    }
                    //Dinner
                    if ($dataBalance->balance_amount >= 50 && $orders[$oDinner] != 0) {
                        $food_item2 = Food::find($orders[$oDinner]);
                        if ($food_item2->status != 0 && $food_item2->food_time_hall->status != 0) {
                            $currentDate = Carbon::now();
                            $nextDate = $currentDate->addDay();
                            $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
                            //check on that day student has how many order
                            $data = Order::where('date', '=', $nextDate)
                                ->where('order_type', '=', 'Dinner')
                                ->where('student_id', '=', $user->id)
                                ->count();
                            $FoodTimeHallData2 = FoodTimeHall::all()->where('food_time_id', '=', $food_item2->food_time_id)->where('hall_id', $user->hall_id)->first();
                            $dataPrice = $food_item2->price;
                            //check on that day student order quantity
                            if ($data == 0 && $food_item2->status != 0 && $FoodTimeHallData2->status != 0 && $dataPrice < $dataBalance->balance_amount) {
                                $data = new Order;
                                $data->student_id = $user->id;
                                $data->order_type = 'Dinner';
                                $data->food_item_id = $food_item2->id;
                                $data->quantity = 1;
                                $data->price = $dataPrice;
                                $data->date = $nextDate;
                                $data->hall_id = $user->hall_id;
                                $data->save();
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
}
