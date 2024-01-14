<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Staff\FoodController;
use App\Http\Controllers\Staff\HomeController;
use App\Http\Controllers\Staff\EmailController;
use App\Http\Controllers\Staff\OrderController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\BalanceController;
use App\Http\Controllers\Staff\PaymentController;
use App\Http\Controllers\Staff\StudentController;
use App\Http\Controllers\Staff\FoodTimeController;
use App\Http\Controllers\Staff\AllocatedSeatController;
use App\Http\Controllers\Staff\Auth\AuthenticatedSessionController;

//Staff Routes
Route::namespace('Staff')->prefix('staff')->name('staff.')->group(function () {
    Route::namespace('Auth')->middleware('guest:staff')->group(function () {
        //Login Route
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    });
    Route::middleware('staff')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
Route::middleware('staff')->prefix('staff')->name('staff.')->group(function () {

    //Profile Routes
    Route::get('/profile', [HomeController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [HomeController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [HomeController::class, 'update'])->name('profile.update');
    Route::get('/profile/changePassword', [HomeController::class, 'editPassword'])->name('profile.editPassword');
    Route::put('/profile/changePassword', [HomeController::class, 'passwordUpdate'])->name('profile.passwordUpdate');

    // Email Crud
    Route::get('email/{id}/delete', [EmailController::class, 'destroy']);
    Route::resource('email', EmailController::class);

    //Suport Ticekts View And Reply
    Route::get('support', [SupportController::class, 'staffIndex'])->name('support.index');
    Route::get('support/{id}', [SupportController::class, 'staffAdmin'])->name('support.show');
    Route::get('support/{id}/reply', [SupportController::class, 'staffReply'])->name('support.reply');
    Route::put('support/{id}', [SupportController::class, 'staffReplyUpdate'])->name('support.replyUpdate');

    // Balance Crud
    Route::get('balance/{id}/delete', [BalanceController::class, 'destroy']);
    Route::resource('balance', BalanceController::class);

    // Payment Crud
    Route::get('payment/{id}/accept', [PaymentController::class, 'acceptby']);
    Route::get('payment/{id}/reject', [PaymentController::class, 'rejectedby']);
    Route::resource('payment', PaymentController::class);

    //Available Positions
    Route::get('room/postion/{selectedValue}', [AllocatedSeatController::class, 'getPositions']);
});
//Assistant Provost Extra
Route::middleware('userType:aprovost')->prefix('staff')->name('staff.')->group(function () {
    //Student Routes
    Route::get('student/import-bulk', [StudentController::class, 'importUser'])->name('student.bulk');
    Route::post('student/import-bulk', [StudentController::class, 'handleImportUser'])->name('student.bulkUpload');
    Route::get('student/{id}/delete', [StudentController::class, 'destroy']);
    Route::resource('student', StudentController::class);
    //RoomAllocation Requests
    Route::get('roomallocation/roomrequests', [AllocatedSeatController::class, 'roomrequests'])->name('roomallocation.roomrequests');
    Route::get('roomallocation/accept/{id}', [AllocatedSeatController::class, 'roomrequestaccept'])->name('roomallocation.accept');
    Route::get('roomallocation/ban/{id}', [AllocatedSeatController::class, 'roomrequestban'])->name('roomallocation.ban');
    Route::get('roomallocation/list/{id}', [AllocatedSeatController::class, 'roomrequestlist'])->name('roomallocation.list');
    Route::get('roomallocation/roomrequests/{id}', [AllocatedSeatController::class, 'showRoomRequest'])->name('roomallocation.showRoomRequest');
    //AllocateSeat From Request
    Route::get('roomallocation/allocate/{id}', [AllocatedSeatController::class, 'RoomRequestAllocate'])->name('roomallocation.RoomRequestAllocate');
    //RoomAllocation CRUD
    Route::get('roomallocation/{id}/delete', [AllocatedSeatController::class, 'destroy']);
    Route::resource('roomallocation', AllocatedSeatController::class);
    // Foodtime Crud
    Route::get('foodtime/{id}/active', [FoodTimeController::class, 'active']);
    Route::get('foodtime/{id}/disable', [FoodTimeController::class, 'disable']);
    Route::resource('foodtime', FoodTimeController::class);

    // Food Crud
    Route::get('food/{id}/active', [FoodController::class, 'active']);
    Route::get('food/{id}/disable', [FoodController::class, 'disable']);
    Route::resource('food', FoodController::class);
});
// Provost Extra
Route::middleware('userType:provost')->prefix('staff')->name('staff.')->group(function () {
    //Student Routes
    Route::get('student/import-bulk', [StudentController::class, 'importUser'])->name('student.bulk');
    Route::post('student/import-bulk', [StudentController::class, 'handleImportUser'])->name('student.bulkUpload');
    Route::get('student/{id}/delete', [StudentController::class, 'destroy']);
    Route::resource('student', StudentController::class);
    //RoomAllocation Requests
    Route::get('roomallocation/roomrequests', [AllocatedSeatController::class, 'roomrequests'])->name('roomallocation.roomrequests');
    Route::get('roomallocation/accept/{id}', [AllocatedSeatController::class, 'roomrequestaccept'])->name('roomallocation.accept');
    Route::get('roomallocation/ban/{id}', [AllocatedSeatController::class, 'roomrequestban'])->name('roomallocation.ban');
    Route::get('roomallocation/list/{id}', [AllocatedSeatController::class, 'roomrequestlist'])->name('roomallocation.list');
    Route::get('roomallocation/roomrequests/{id}', [AllocatedSeatController::class, 'showRoomRequest'])->name('roomallocation.showRoomRequest');
    //AllocateSeat From Request
    Route::get('roomallocation/allocate/{id}', [AllocatedSeatController::class, 'RoomRequestAllocate'])->name('roomallocation.RoomRequestAllocate');
    //RoomAllocation CRUD
    Route::get('roomallocation/{id}/delete', [AllocatedSeatController::class, 'destroy']);
    Route::resource('roomallocation', AllocatedSeatController::class);
    // Staff Crud
    Route::get('staff/{id}/delete', [StaffController::class, 'destroy']);
    Route::get('staff/{id}/change', [StaffController::class, 'change']);
    Route::put('staff/{id}/changeUpdate', [StaffController::class, 'changeUpdate'])->name('staff.changeUpdate');
    Route::resource('staff', StaffController::class);

    // Foodtime Crud
    Route::get('foodtime/{id}/active', [FoodTimeController::class, 'active']);
    Route::get('foodtime/{id}/disable', [FoodTimeController::class, 'disable']);
    Route::get('foodtime/{id}/delete', [FoodTimeController::class, 'destroy']);
    Route::resource('foodtime', FoodTimeController::class);

    // Food Crud
    Route::get('food/{id}/active', [FoodController::class, 'active']);
    Route::get('food/{id}/disable', [FoodController::class, 'disable']);
    Route::get('food/{id}/delete', [FoodController::class, 'destroy']);
    Route::resource('food', FoodController::class);
});
Route::middleware('userType:staff')->prefix('staff')->name('staff.')->group(function () {
    // Order Crud
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/status/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/valid/{id}', [OrderController::class, 'update'])->name('orders.valid');
    Route::get('orders/printToken/{id}', [OrderController::class, 'printNet'])->name('orders.printToken');
    Route::post('orders/searchall/', [OrderController::class, 'searchByDate'])->name('orders.searchByDate');
    Route::post('orders/search/', [OrderController::class, 'searchByHistory'])->name('orders.searchByHistory');
    //Scan QR Code
    Route::get('orders/scan/', [OrderController::class, 'scan'])->name('orders.scan');
    Route::get('orders/scan/{id}', [OrderController::class, 'qrcodescanlink'])->name('orders.qrcodescanlink');
    Route::post('orders/qrcodescan/', [OrderController::class, 'qrcodescan'])->name('orders.qrcodescan');
});
