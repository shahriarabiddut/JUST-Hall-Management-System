<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\SupportController;
use App\Http\Controllers\Staff\FoodController;
use App\Http\Controllers\Staff\HomeController;
use App\Http\Controllers\Staff\RoomController;
use App\Http\Controllers\Staff\EmailController;
use App\Http\Controllers\Staff\OrderController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\BalanceController;
use App\Http\Controllers\Staff\PaymentController;
use App\Http\Controllers\Staff\StudentController;
use App\Http\Controllers\Staff\FoodTimeController;
use App\Http\Controllers\Staff\RoomTypeController;
use App\Http\Controllers\Staff\AllocatedSeatController;
use App\Http\Controllers\Staff\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Staff\HistoryController;

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
    Route::get('support', [SupportController::class, 'index'])->name('support.index');
    Route::get('support/{id}', [SupportController::class, 'show'])->name('support.show');
    Route::get('support/{id}/reply', [SupportController::class, 'reply'])->name('support.reply');
    Route::put('support/{id}', [SupportController::class, 'update'])->name('support.replyUpdate');

    // Balance Crud
    Route::resource('balance', BalanceController::class);

    // Payment Crud
    Route::get('payment/{id}/accept', [PaymentController::class, 'acceptby']);
    Route::get('payment/{id}/reject', [PaymentController::class, 'rejectedby']);
    Route::resource('payment', PaymentController::class);

    //Available Positions
    Route::get('room/postion/{selectedValue}', [AllocatedSeatController::class, 'getPositions']);

    // For Only Provost and Assistant Provost
    //Student Routes
    Route::get('student/import-bulk', [StudentController::class, 'importUser'])->name('student.bulk');
    Route::post('student/import-bulk', [StudentController::class, 'handleImportUser'])->name('student.bulkUpload');
    Route::get('student/{id}/delete', [StudentController::class, 'destroy']);
    Route::post('student/search/', [StudentController::class, 'search'])->name('student.search');
    Route::resource('student', StudentController::class);
    //deduct BalanceCommand  
    Route::get("/deductBalance", [StudentController::class, 'deductBalanceStaff'])->name('student.deductBalance');
    //RoomAllocation Requests
    Route::get('roomallocation/roomrequests', [AllocatedSeatController::class, 'roomrequests'])->name('roomallocation.roomrequests');
    Route::get('roomallocation/accept/{id}', [AllocatedSeatController::class, 'roomrequestaccept'])->name('roomallocation.accept');
    Route::get('roomallocation/ban/{id}', [AllocatedSeatController::class, 'roomrequestban'])->name('roomallocation.ban');
    Route::get('roomallocation/list/{id}', [AllocatedSeatController::class, 'roomrequestlist'])->name('roomallocation.list');
    Route::get('roomallocation/roomrequests/{id}', [AllocatedSeatController::class, 'showRoomRequest'])->name('roomallocation.showRoomRequest');
    //AllocateSeat From Request
    Route::post('roomallocation/allocate/', [AllocatedSeatController::class, 'RoomRequestAllocate'])->name('roomallocation.RoomRequestAllocate');
    //RoomAllocation CRUD
    Route::get('roomallocation/{id}/delete', [AllocatedSeatController::class, 'destroy']);
    Route::resource('roomallocation', AllocatedSeatController::class);
    // Room ALlocaton Using CSV
    Route::get('roomallocationadd/import-bulk', [AllocatedSeatController::class, 'importAllocation'])->name('roomallocation.bulk');
    Route::post('roomallocationadd/import-bulk', [AllocatedSeatController::class, 'handleImportAllocation'])->name('roomallocation.bulkUpload');
    // Foodtime Crud
    Route::get('foodtime/{id}/active', [FoodTimeController::class, 'active']);
    Route::get('foodtime/{id}/disable', [FoodTimeController::class, 'disable']);
    Route::resource('foodtime', FoodTimeController::class);
    // Food Crud
    Route::get('food/{id}/active', [FoodController::class, 'active']);
    Route::get('food/{id}/disable', [FoodController::class, 'disable']);
    Route::get('food/{id}/delete', [FoodController::class, 'destroy']);
    Route::resource('food', FoodController::class);
    // Order Crud
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/status/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/valid/{id}', [OrderController::class, 'update'])->name('orders.valid');
    Route::get('orders/printToken/{id}', [OrderController::class, 'printNet'])->name('orders.printToken');
    Route::post('orders/searchall/', [OrderController::class, 'searchByDate'])->name('orders.searchByDate');
    Route::post('orders/search/', [OrderController::class, 'searchByHistory'])->name('orders.searchByHistory');
    Route::post('orders/searchByDateDownload/', [OrderController::class, 'searchByDateDownload'])->name('orders.searchByDateDownload');
    //Scan QR Code
    Route::get('orders/scan/', [OrderController::class, 'scan'])->name('orders.scan');
    Route::get('orders/scan/{id}', [OrderController::class, 'qrcodescanlink'])->name('orders.qrcodescanlink')->where('id', '(.*(?:%2F:)?.*)');
    Route::post('orders/qrcodescan/', [OrderController::class, 'qrcodescan'])->name('orders.qrcodescan');
});
//Assistant Provost Extra
Route::middleware('userType:aprovost')->prefix('staff')->name('staff.')->group(function () {
});
// Provost Extra
Route::middleware('userType:provost')->prefix('staff')->name('staff.')->group(function () {
    // RoomTypes Routes
    Route::get('roomtype', [RoomTypeController::class, 'index'])->name('roomtype.index');
    Route::get('roomtype/{id}', [RoomTypeController::class, 'show'])->name('roomtype.show');

    // Room Routes
    Route::get('rooms/{id}/delete', [RoomController::class, 'destroy']);
    Route::get('rooms/import-bulk', [RoomController::class, 'importRoom'])->name('rooms.bulk');
    Route::post('rooms/import-bulk', [RoomController::class, 'handleImportRoom'])->name('rooms.bulkUpload');
    Route::resource('rooms', RoomController::class);
    // Staff Crud
    Route::get('staff/{id}/delete', [StaffController::class, 'destroy']);
    Route::get('staff/{id}/change', [StaffController::class, 'change']);
    Route::put('staff/{id}/changeUpdate', [StaffController::class, 'changeUpdate'])->name('staff.changeUpdate');
    Route::resource('staff', StaffController::class);

    // History
    Route::get('settings/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('settings/history/{id}', [HistoryController::class, 'show'])->name('history.show');
    Route::get('settings/historyRead', [HistoryController::class, 'read'])->name('history.read');

    Route::post('settings/historyD/searchMonth/', [HistoryController::class, 'searchByMonth'])->name('history.searchByMonth');
    Route::post('settings/historyD/readSearch', [HistoryController::class, 'readSearch'])->name('history.readSearch');
    Route::get('settings/historyD/chart-data', [HistoryController::class, 'chartData'])->name('chartData');;

    // Settings Crud
    Route::get('settings/', [HomeController::class, 'settings'])->name('settings.index');
    Route::put('settings/update/{id}', [HomeController::class, 'settingsUpdate'])->name('settings.update');
});
Route::middleware('userType:staff')->prefix('staff')->name('staff.')->group(function () {
});
