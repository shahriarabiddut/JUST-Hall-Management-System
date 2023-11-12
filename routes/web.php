<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\MealTokenController;

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

Route::get('/', function () {
    return view('home');
})->name('root');

Route::get('/tokenPrint', [MealTokenController::class, 'TokenPrintQueue'])->name('tokenPrint');
//ESP 32 Token Print Queue Delete
Route::get('/tpqd/{id}', [MealTokenController::class, 'TokenPrintQueueDelete'])->name('tokenPrint');
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
    Route::get('mealtoken/print/{id}', [MealTokenController::class, 'print'])->name('mealtoken.print');
    //Print Extra ESp32
    Route::get('mealtoken/printNet/{id}', [MealTokenController::class, 'printNet'])->name('mealtoken.printnet');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/staff.php';
