<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Balance;
use App\Models\HallOption;
use App\Models\RoomRequest;
use App\Models\AllocatedSeats;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('profile.*', function ($view) {
            $userid = Auth::user()->id;
            $dataMessage = RoomRequest::all()->where('user_id', '=', $userid);
            $view->with('dataMessage', $dataMessage);
        });
        view()->composer('profile.*', function ($view) {
            $userid = Auth::user()->id;
            $sorryRoomSidebar = 0;
            $dataForRoomAllocation = AllocatedSeats::all()->where('user_id', '=', $userid);
            if (count($dataForRoomAllocation) > 0) {
                $sorryRoomSidebar = 1;
            }
            $view->with('sorryRoomSidebar', $sorryRoomSidebar);
        });
        view()->composer('profile.*', function ($view) {
            $userid = Auth::user()->id;
            $dataBalance = Balance::all()->where('student_id', '=', $userid)->first();
            $view->with('dataBalance', $dataBalance);
        });
        view()->composer('*', function ($view) {
            $HallOption = HallOption::all();
            $view->with('HallOption', $HallOption);
        });
        view()->composer('*', function ($view) {
            $currentDateDash = Carbon::now(); // get current date and time
            $currentDateDash = $currentDateDash->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17
            $view->with('currentDateDash', $currentDateDash);
        });
    }
}
