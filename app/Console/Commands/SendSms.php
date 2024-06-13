<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Hall;
use App\Models\Order;
use App\Models\Balance;
use App\Models\Student;
use App\Mail\AdminEmail;
use App\Models\HallOption;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Emails to User';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $users = Student::all();
        foreach ($users as $user) {
            $student_id = $user->id;
            $student_email = $user->email;
            if ($user->ms == 1) {
                $fixedCharge = $users->hall->fixed_cost_master;
            } else {
                $fixedCharge = $users->hall->fixed_cost;
            }
            $today = Carbon::now();
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $sumofthatmonth = Order::whereBetween('created_at', [$startDate, $endDate])->where('student_id', '=', $student_id)->sum('price');
            //find balance if needed then deuduct
            $data = Balance::all()->where('student_id', '=', $student_id)->first();
            $balance = $data->balance_amount;
            $new_balance_amount = $data->balance_amount;
            if ($sumofthatmonth < $fixedCharge) {
                $charge = $fixedCharge - $sumofthatmonth;
                $new_balance_amount = $balance - $charge;

                //Update New Balance
                $data->balance_amount = $new_balance_amount;
                $data->save();
                // Add fixed charge as order
                $data2 = new Order;
                $data2->student_id = $student_id;
                $data2->order_type = 'MonthlyFixedCharge';
                $data2->food_item_id = 0;
                $data2->quantity = 0;
                $data2->price = $charge;
                $data2->date = $endDate;
                $data2->hall_id = $users->hall->id;
                $data2->save();
                // Order Done

                $emailBody = 'You have ordered this month : ' . $sumofthatmonth . ' taka. Your Old Balance was : ' . $balance . ' taka and deducting fixed charge = ' . $fixedCharge . ' taka , Your Current Balance is : ' . $new_balance_amount;
            } else {
                $emailBody = 'You have ordered this month : ' . $sumofthatmonth . ' taka. Your Old Balance was : ' . $balance . ' taka and No Money was deducted today!';
            }
            //email
            // The email sending is done using the to method on the Mail facade
            Mail::to($student_email)->send(new AdminEmail($emailBody, 'Monthly Deduction', 'Balance information of Month ' . $today->format('F')));
            //email 

        }
    }
}
