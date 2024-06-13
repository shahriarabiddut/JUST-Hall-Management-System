<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Student;
use Carbon\Carbon;

class SslCommerzPaymentController extends Controller
{
    public function index(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        # User INFORMATION
        $post_data['cus_name'] = $request->createdby;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->email;
        $post_data['cus_phone'] = $request->mobile;
        $post_data['cus_student_id'] = $request->student_id;

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        //Get Hall Id
        $student = Student::find($request->student_id);
        if ($student->hall->enable_payment == 0) {
            return redirect()->route('student.dashboard')->with('danger', 'New Payments are Disabled by Hall Administrator!');
        }
        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('payments')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'student_id' => $post_data['cus_student_id'],
                'hall_id' => $student->hall_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function payViaAjax(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        # User INFORMATION
        $post_data['cus_name'] = $request->createdby;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->email;
        $post_data['cus_phone'] = $request->mobile;
        $post_data['cus_student_id'] = $request->student_id;

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";
        //Get Hall Id
        $student = Student::find($request->student_id);
        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('payments')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'student_id' => $post_data['cus_student_id'],
                'hall_id' => $student->hall_id
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                $update_product = DB::table('payments')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                $data = 1;
                return view('layouts.success', ['data' => $data]);
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            $data = 1;
            return view('layouts.success', ['data' => $data]);
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            $data = 1;
            return view('layouts.failed', ['data' => $data]);
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            $data = 0;
            return view('layouts.failed', ['data' => $data]);
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            $data = 2;
            return view('layouts.success', ['data' => $data]);
        } else {
            $data = 1;
            return view('layouts.failed', ['data' => $data]);
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            $data = 2;
            return view('layouts.failed', ['data' => $data]);
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            $data = 2;
            return view('layouts.success', ['data' => $data]);
        } else {
            $data = 1;
            return view('layouts.failed', ['data' => $data]);
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('payments')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('payments')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    $data = 1;
                    return view('layouts.success', ['data' => $data]);
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                #That means Order status already updated. No need to udate database.
                $data = 2;
                return view('layouts.success', ['data' => $data]);
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                $data = 1;
                return view('layouts.failed', ['data' => $data]);
            }
        } else {
            $data = 1;
            return view('layouts.failed', ['data' => $data]);
        }
    }
}
