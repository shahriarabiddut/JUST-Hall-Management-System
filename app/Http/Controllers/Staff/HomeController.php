<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Order;
use App\Models\Staff;
use App\Models\FoodTime;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    //
    public function index()
    {
        //Order Data
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        // $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate = $currentDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17

        $resulttitle = [];
        $total_food_times = FoodTime::select('id')->where('status', '=', '1')->get();
        $results = [];
        foreach ($total_food_times as $total_food_time) {
            $i = $total_food_time->id;
            $results[] = $this->foodTime($nextDate, $i);
            $resulttitle[] = FoodTime::all()->where('id', '=', $i)->first();
        }


        return view('staff.dashboard', ['results' => $results, 'resulttitle' => $resulttitle, 'nextDate' => $nextDate]);
    }
    public function foodTime(string $nextDate, string $id)
    {
        //foodtype
        $food_time = FoodTime::all()->where('status', '=', '1')->where('id', '=', $id)->first();
        //Food Item for search
        $foods = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $id);
        $food_id_data = [];
        foreach ($foods as $food) {
            $food_id_data[] = $food->id;
        }
        // total count of foods for forloop
        $total_food_count = count($foods);
        $food_data = [];
        for ($i = 1; $i <= $total_food_count; $i++) {
            $food_item_id = $food_id_data[$i - 1];
            $food_data[$i] = Order::where('date', '=', $nextDate)
                ->where('order_type', '=', $food_time->title)
                ->where('food_item_id', '=', $food_item_id)->sum('quantity');
        }

        return [$food_data, $foods];
    }

    /**
     * Display the user's profile form.
     */
    public function view(): View
    {
        $user = Auth::guard('staff')->user();
        return view('staff.partials.view', [
            'user' => $user,
        ]);
    }
    public function edit(): View
    {
        $user = Auth::guard('staff')->user();
        return view('staff.partials.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'userid' => 'required',
        ]);
        $data = Staff::find($request->userid);
        //If user Gieven address
        if ($request->has('address')) {
            $formFields['address'] = $request->address;
        }
        //If user Gieven any PHOTO
        if ($request->hasFile('photo')) {
            $formFields['photo'] = $request->file('photo')->store('StaffPhoto', 'public');
        } else {
            $formFields['photo'] = $request->prev_photo;
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->mobile;
        $data->address = $request->address;
        $data->photo = $formFields['photo'];

        $data->save();

        return Redirect::route('staff.profile.view')->with('success', 'Profile Updated Successfully!');
    }
    /**
     * Update the user's password information.
     */
    public function editPassword(Request $request): View
    {
        $user = Auth::guard('staff')->user();
        return view('staff.partials.changePassword', [
            'user' => $user,
        ]);
    }


    public function passwordUpdate(Request $request)
    {
        $formFields = $request->validate([
            'currentPassword' => 'required| min:6',
            'newPassword' => 'required| min:6',
            'confirmPassword' => 'required|same:newPassword',
            'userid' => 'required',
        ]);
        $data = Staff::find($request->userid);
        $oldPass = $data->password;
        $currentPassword = $request->currentPassword;
        if (Hash::check($currentPassword, $oldPass)) {
            //If user Given confirm poassword same
            $data->password = bcrypt(($request->newPassword));
            $data->save();
            return Redirect::route('staff.profile.view')->with('success', 'Password Updated Succesfully!');
        } else {
            return Redirect::back()->with('danger', "Current Password Didn't Match");
        }
    }
}
