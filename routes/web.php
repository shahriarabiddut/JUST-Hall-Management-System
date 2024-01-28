<?php

use App\Mail\MyTestEmail;
use App\Models\HallOption;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\MealTokenController;
use App\Http\Controllers\SslCommerzPaymentController;
/* 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/testroute', function () {
    $name = "Biddut";

    // The email sending is done using the to method on the Mail facade
    Mail::to('shahriarabiddut@gmail.com')->send(new MyTestEmail($name));
});

Route::get('/', function () {
    return view('home');
})->name('root');

//
$printingOption = HallOption::all()->where('name', 'print')->first();
if ($printingOption->value != 0) {
    // Route::get('/tokenPrint', [MealTokenController::class, 'TokenPrintQueue'])->name('tokenPrint');
    Route::get('/tokenPrint/{value1}', [MealTokenController::class, 'TokenPrintQueue2'])->name('tokenPrint');
    Route::get('/tpqd/{id}&{order_id}&{rollno}/delete', [MealTokenController::class, 'TokenPrintQueueDelete'])->name('tokenprint.delete');
    Route::get('/tpqd/{value}/{id}&{order_id}&{rollno}/delete', [MealTokenController::class, 'TokenPrintQueueDelete2'])->name('tokenprint.delete2');
    Route::get('orders/scan/{value}/{id}', [App\Http\Controllers\Staff\OrderController::class, 'qrcodescanesp'])->name('orders.qrcodescanlink')->where('id', '(.*(?:%2F:)?.*)');
}
//
//ESP 32 Token Print Queue Delete
// Route::get('/tpqd/{id}&{order_id}&{rollno}', [MealTokenController::class, 'TokenPrintQueueDelete'])->name('tokenprint.delete');

//User Routes
Route::get('student', [ProfileController::class, 'index'])->middleware(['auth'])->name('student.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('student')->name('student.')->group(function () {

    //Profile Routes
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/changePassword', [ProfileController::class, 'editPassword'])->name('profile.editPassword');
    Route::put('/profile/changePassword', [ProfileController::class, 'passwordUpdate'])->name('profile.passwordUpdate');

    //Room Routes
    Route::get('rooms/myroom', [ProfileController::class, 'myroom'])->name('myroom');
    Route::get('rooms/request', [ProfileController::class, 'roomrequest'])->name('roomrequest');
    Route::post('rooms/applyrequest', [ProfileController::class, 'roomrequeststore'])->name('roomrequeststore');
    Route::get('rooms/requestshow', [ProfileController::class, 'roomrequestshow'])->name('roomrequestshow');
    Route::get('rooms/request/{id}/edit', [ProfileController::class, 'roomrequestedit'])->name('roomrequest.edit');
    Route::put('rooms/request/update', [ProfileController::class, 'roomrequestupdate'])->name('roomrequest.update');
    Route::get('rooms/requestshow/{id}/delete', [ProfileController::class, 'roomrequestdestroy'])->name('roomrequest.destroy');

    //Support Routes
    Route::get('support/{id}/delete', [SupportController::class, 'destroy']);
    Route::resource('support', SupportController::class);

    //Balance Routes
    Route::resource('balance', BalanceController::class);
    //Payment Routes
    Route::resource('payments', PaymentController::class);
    // SSLCOMMERZ Start
    Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('ssl.pay');
    //SSLCOMMERZ END

    //Order Routes
    Route::get('order/foodmenu', [OrderController::class, 'foodmenu'])->name('order.foodmenu');
    Route::get('order/foodmenu/{id}', [OrderController::class, 'createOrder'])->name('order.createOrder');
    Route::post('orders/search/', [OrderController::class, 'searchByDate'])->name('order.searchByDate');
    Route::post('orders/searchMonth/', [OrderController::class, 'searchByMonth'])->name('order.searchByMonth');
    Route::resource('order', OrderController::class);
    Route::get('order/foodmenu/{id}/advance', [OrderController::class, 'createOrderAdvance'])->name('order.createOrderAdvance');
    Route::post('order/foodmenu/advance', [OrderController::class, 'storeOrderAdvance'])->name('order.storeAdvance');
    Route::get('order/{id}/delete', [OrderController::class, 'destroy'])->name('order.delete');


    //mealtoken Routes
    Route::get('mealtoken/generate/{id}', [MealTokenController::class, 'generate'])->name('mealtoken.generate');
    Route::get('mealtoken/{id}/show', [MealTokenController::class, 'showbyorder'])->name('mealtoken.showbyorder');
    Route::resource('mealtoken', MealTokenController::class);

    //Meal Token Print Routes
    // Route::get('mealtoken/print/{id}', [MealTokenController::class, 'print'])->name('mealtoken.print');
    //Print Extra ESp32
    Route::get('mealtoken/printNet/{id}', [MealTokenController::class, 'printNet'])->name('mealtoken.printnet');
});
// SSLCOMMERZ Start
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax'])->name('ssl.payViaAjax');

Route::post('/success', [SslCommerzPaymentController::class, 'success'])->name('ssl.success');
Route::post('/fail', [SslCommerzPaymentController::class, 'fail'])->name('ssl.fail');
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('ssl.cancel');
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn'])->name('ssl.ipn');
//SSLCOMMERZ END
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/staff.php';
