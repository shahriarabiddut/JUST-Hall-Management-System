<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\FoodTimeController;
use App\Http\Controllers\Admin\AllocatedSeatController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HallController;

//Admin
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->middleware('guest:admin')->group(function () {
        //Login Route
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('adminlogin');
    });
    Route::middleware('admin')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    // Profle
    Route::get('/profile/changePassword', [HomeController::class, 'editPassword'])->name('profile.editPassword');
    Route::put('/profile/changePassword', [HomeController::class, 'passwordUpdate'])->name('profile.passwordUpdate');
    // Settings Crud
    Route::get('settings/', [HomeController::class, 'edit'])->name('settings.index');
    Route::put('settings/update/{id}', [HomeController::class, 'update'])->name('settings.update');
    // History
    Route::get('settings/history', [HomeController::class, 'historyIndex'])->name('history.index');
    Route::get('settings/history/{id}', [HomeController::class, 'historyShow'])->name('history.show');
    Route::get('settings/historyRead', [HomeController::class, 'historyRead'])->name('history.read');
    // Email Crud
    Route::get('email/{id}/delete', [EmailController::class, 'destroy']);
    Route::resource('email', EmailController::class);

    // RoomTypes Routes
    Route::get('roomtype/{id}/delete', [RoomTypeController::class, 'destroy']);
    Route::resource('roomtype', RoomTypeController::class);
    // Delete RoomType Images
    Route::get('roomtypeImage/delete/{id}', [RoomTypeController::class, 'destroy_image']);

    // Room Routes
    Route::get('rooms/{id}/delete', [RoomController::class, 'destroy']);
    Route::get('rooms/import-bulk', [RoomController::class, 'importRoom'])->name('rooms.bulk');
    Route::post('rooms/import-bulk', [RoomController::class, 'handleImportRoom'])->name('rooms.bulkUpload');
    Route::resource('rooms', RoomController::class);

    // Student Routes
    Route::get('student/balances', [BalanceController::class, 'adminIndex'])->name('student.balances');
    Route::get('student/import-bulk', [StudentController::class, 'importUser'])->name('student.bulk');
    Route::post('student/import-bulk', [StudentController::class, 'handleImportUser'])->name('student.bulkUpload');
    Route::get('student/{id}/delete', [StudentController::class, 'destroy']);
    Route::resource('student', StudentController::class);


    // Staff Crud
    Route::get('staff/{id}/delete', [StaffController::class, 'destroy']);
    Route::get('staff/{id}/change', [StaffController::class, 'change']);
    Route::put('staff/{id}/changeUpdate', [StaffController::class, 'changeUpdate'])->name('staff.changeUpdate');
    Route::resource('staff', StaffController::class);

    //RoomAllocation Requests
    Route::get('roomallocation/roomrequests', [AllocatedSeatController::class, 'roomrequests'])->name('roomallocation.roomrequests');
    Route::get('roomallocation/accept/{id}', [AllocatedSeatController::class, 'roomrequestaccept'])->name('roomallocation.accept');
    Route::get('roomallocation/ban/{id}', [AllocatedSeatController::class, 'roomrequestban'])->name('roomallocation.ban');
    Route::get('roomallocation/list/{id}', [AllocatedSeatController::class, 'roomrequestlist'])->name('roomallocation.list');
    Route::get('roomallocation/roomrequests/{id}', [AllocatedSeatController::class, 'showRoomRequest'])->name('roomallocation.showRoomRequest');
    Route::get('roomrequest/generate-pdf/{id}',  [AllocatedSeatController::class, 'generatePdf'])->name('generatepdf');
    //Available Positions
    Route::get('room/postion/{selectedValue}', [AllocatedSeatController::class, 'getPositions']);
    //Room Issue
    Route::get('/roomallocationissue', [HomeController::class, 'roomallocationissue'])->name('roomallocation.issue');
    Route::get('/roomallocationissue/{id}', [HomeController::class, 'roomallocationissueview'])->name('roomallocation.issueview');
    // Order Crud
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/status/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/valid/{id}', [OrderController::class, 'update'])->name('orders.valid');
    Route::get('orders/printToken/{id}', [OrderController::class, 'print'])->name('orders.printToken');
    Route::post('orders/searchall/', [OrderController::class, 'searchByDate'])->name('orders.searchByDate');
    Route::post('orders/search/', [OrderController::class, 'searchByHistory'])->name('orders.searchByHistory');

    //AllocateSeat From Request
    Route::get('roomallocation/allocate/{id}', [AllocatedSeatController::class, 'RoomRequestAllocate'])->name('roomallocation.RoomRequestAllocate');
    //RoomAllocation CRUD
    Route::get('roomallocation/{id}/delete', [AllocatedSeatController::class, 'destroy']);
    Route::get('roomallocate/{id}/add', [AllocatedSeatController::class, 'create1'])->name('roomallocation.add');
    Route::resource('roomallocation', AllocatedSeatController::class);
    // Route::get('roomallocation/available-position/{room_id}', [AllocatedSeatController::class,'available_position']);

    //Suport Ticekts View
    Route::get('support', [HomeController::class, 'supportIndex'])->name('support.index');
    Route::get('support/{id}', [HomeController::class, 'supportShow'])->name('support.show');

    //Command Test 
    Route::get("/deductBalance", [App\Http\Controllers\ProcessController::class, 'deductBalance'])->name('student.deductBalance');

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

    // Foodtime Crud
    Route::get('hall/{id}/active', [HallController::class, 'active']);
    Route::get('hall/{id}/disable', [HallController::class, 'disable']);
    Route::get('hall/{id}/delete', [HallController::class, 'destroy']);
    Route::resource('hall', HallController::class);
});
