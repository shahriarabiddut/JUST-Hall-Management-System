<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AllocatedSeatController;
use App\Http\Controllers\Admin\StaffDepartmentController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;

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
    // Settings Crud
    Route::get('settings/', [HomeController::class, 'edit']);
    Route::put('settings/update/{id}', [HomeController::class, 'update']);
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
    Route::resource('rooms', RoomController::class);

    // Student Routes
    Route::get('student/balances', [BalanceController::class, 'adminIndex'])->name('student.balances');
    Route::get('student/import-bulk', [StudentController::class, 'importUser'])->name('student.bulk');
    Route::post('student/import-bulk', [StudentController::class, 'handleImportUser'])->name('student.bulkUpload');
    Route::get('student/{id}/delete', [StudentController::class, 'destroy']);
    Route::resource('student', StudentController::class);

    // Department Routes
    Route::get('department/{id}/delete', [StaffDepartmentController::class, 'destroy']);
    Route::resource('department', StaffDepartmentController::class);

    // Staff Routes
    // Staff Payment
    Route::get('staff/payments/{id}', [StaffController::class, 'all_payment']);
    Route::get('staff/payment/{id}/add', [StaffController::class, 'add_payment']);
    Route::post('staff/payment/{id}', [StaffController::class, 'save_payment']);
    Route::get('staff/payment/{id}/{stuff_id}/delete', [StaffController::class, 'delete_payment']);
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
    Route::resource('roomallocation', AllocatedSeatController::class);
    // Route::get('roomallocation/available-position/{room_id}', [AllocatedSeatController::class,'available_position']);

    //Suport Ticekts View
    Route::get('support', [SupportController::class, 'adminIndex'])->name('support.index');
    Route::get('support/{id}', [SupportController::class, 'showAdmin'])->name('support.show');

    //Command Test 
    Route::get("/deductBalance", [App\Http\Controllers\ProcessController::class, 'deductBalance'])->name('student.deductBalance');
});
