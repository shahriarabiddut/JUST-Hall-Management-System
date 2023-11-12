<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\MealToken;
use App\Models\HallOption;
use App\Models\TokenPrintQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

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
            $qrcode = QrCode::size(300)->generate($link);
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
            $qrcode = QrCode::size(300)->generate($link);
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
        if ($data->status != 1) {
            //Check if printqueue Exist
            $printqueue = TokenPrintQueue::all()->where('id', '=', $data->id)->first();
            if ($printqueue == null) {
                // Add On Print Queue
                $newdata = new TokenPrintQueue();
                $newdata->id = $data->id;
                $newdata->data = $data;
                $newdata->save();
                //Change Status to 1
                // Update Token Status
                //
                return redirect()->route('student.mealtoken.index')->with('success', 'Token On Print Queue!');
            } else {
                return redirect()->route('student.mealtoken.index')->with('danger', 'Token is Allready on Print Queue!');
            }
        } else {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Token Expired!');
        }
    }
    public function TokenPrintQueue()
    {
        $data = TokenPrintQueue::all();
        return response()->json($data);
    }
    //Delete From Print Queue
    public function TokenPrintQueueDelete(string $id)
    {
        $data = TokenPrintQueue::all()->where('id', '=', $id)->first();
        $data->delete();
        return response()->json(1);
    }

    //Print meal token
    public function print2(string $id)
    {
        //MealData
        $data = MealToken::find($id);
        // Check Allready Printed or Not
        if ($data->status == 1) {
            return redirect()->route('student.mealtoken.index')->with('danger', ' Token Allready Printed!');
        }
        //
        $currenturl = url()->full();
        //SiteData
        $store_name_data = HallOption::all();
        //User Data
        $user_data = Auth::user();
        //FoodData
        $fooddata = Order::find($data->order_id);
        // Set params
        $mid = $user_data->name;
        $store_name = $store_name_data[8]->value;
        $store_address = $store_name_data[0]->value;
        $store_phone = '1234567890';
        $store_email = $store_name_data[8]->value;
        $store_website = env('APP_URL');
        // $tax_percentage = 10;
        $transaction_id = 'MTNo' . $data->id;

        // Set items
        $items = [
            [
                'name' => $data->food_name,
                'qty' => $data->quantity,
                'price' => $fooddata->price * 1000,
            ],
        ];
        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        $printerdatax = $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        if ($printerdatax != null) {
            // Set store info
            $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

            // Add items
            foreach ($items as $item) {
                $printer->addItem(
                    $item['name'],
                    $item['qty'],
                    $item['price']
                );
            }
            // Set tax
            // $printer->setTax($tax_percentage);

            // Calculate total
            $printer->calculateSubTotal();
            $printer->calculateGrandTotal();

            // Set transaction ID
            $printer->setTransactionID($transaction_id);

            // Set qr code
            $printer->setQRcode([
                'tid' => $currenturl,
            ]);

            if ($printer->printReceipt() == 'null') {
                return redirect()->route('student.mealtoken.index')->with('danger', 'Printer & Wifi is not on Same IP!');
                //Update Token status To Error
                $data->status = 2;
                $data->save();
            } else {
                // Print Reciept 
                $printer->printReceipt();
                //Update Token status
                $data->status = 1;
                $data->save();

                return redirect()->route('student.mealtoken.index')->with('success', ' Token Printed!');
            }
        } else {
            //Update Token status
            $data->status = 0;
            $data->save();
            return redirect()->route('student.mealtoken.index')->with('danger', ' Somethings Wrong!Printer & Wifi is not on Same IP!');
        }
    }
    public function print(string $id)
    {
        //MealData Date
        $data = MealToken::find($id);
        $date_MealToken = $data->order_id;
        $dataOrder = Order::all()->where('id', '=', $date_MealToken)->first();
        $date_MealToken = $dataOrder->date;
        // Check Allready Printed or Not
        if ($data->status == 1) {
            return redirect()->route('student.mealtoken.index')->with('danger', ' Token Allready Printed!');
        }
        //
        $currenturl = url()->full();
        //SiteData
        $store_name_data = HallOption::all();
        //User Data
        $user_data = Auth::user();
        //FoodData
        $fooddata = Order::find($data->order_id);
        // Set params
        $mid = $user_data->name;
        $store_name = $store_name_data[8]->value;
        $store_address = $date_MealToken;
        $store_phone = '1234567890';
        $store_email = $store_name_data[8]->value;
        $store_website = env('APP_URL');
        // $tax_percentage = 10;
        $transaction_id = 'MTNo' . $data->id;

        // Set items
        $items = [
            [
                'name' => $data->food_name,
                'qty' => $data->quantity,
                'price' => $fooddata->price * 1000,
            ],
        ];
        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        $printerdatax = $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        // $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $currenturl,
        ]);

        if ($printer->printReceipt() == 'null') {
            return redirect()->route('student.mealtoken.index')->with('danger', 'Printer & Wifi is not on Same IP!');
            //Update Token status To Error
            $data->status = 2;
            $data->save();
        } else {
            // Print Reciept 
            $printer->printReceipt();
            //Update Token status
            $data->status = 1;
            $data->save();

            return redirect()->route('student.mealtoken.index')->with('success', ' Token Printed!');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Delete or Cancel Advance Order
    }
}
