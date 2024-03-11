<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Hall;
use App\Models\Order;
use App\Models\Staff;
use App\Models\History;
use App\Models\FoodTime;
use Illuminate\View\View;
use App\Models\HallOption;
use App\Models\FoodTimeHall;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RoomIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::guard('staff')->user()->hall_id;
            return $next($request);
        });
    }
    //
    public function index()
    {
        //Order Data
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        // $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate = $currentDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17

        $resulttitle = [];
        //
        $dataFoodTime = FoodTimeHall::all()->where('status', '1')->where('hall_id', $this->hall_id);
        $total_food_times = [];
        foreach ($dataFoodTime as $dFT) {
            $total_food_times[] = FoodTime::find($dFT->food_time_id);
        }
        //
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
        $foods = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $id)->where('hall_id', $this->hall_id);
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
            $formFields['photo'] = 'app/public/' . $request->file('photo')->store('StaffPhoto', 'public');
        } else {
            $formFields['photo'] = $request->prev_photo;
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->mobile;
        $data->address = $request->address;
        $data->photo =  $formFields['photo'];

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
    public function settings()
    {
        $data = Hall::find($this->hall_id);
        if ($data == null) {
            return redirect()->route('staff.dashboard')->with('danger', 'Not Found!');
        }
        if ($data->id != $this->hall_id) {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized Access!');
        }
        if ($data->status == 0) {
            return redirect()->route('staff.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
        }
        return view('staff.settings.edit', ['data' => $data]);
    }
    public function settingsUpdate(Request $request, $id)
    {
        //
        $request->validate([
            'print' => 'required',
            'secret' => 'required',
            'fixed_cost' => 'required',
            'fixed_cost_masters' => 'required',
        ]);
        $data = Hall::find($id);
        if ($data->id != $this->hall_id) {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized Access!');
        }
        $data->enable_print = $request->print;
        $data->enable_payment = $request->payment;
        $data->secret = $request->secret;
        $data->fixed_cost = $request->fixed_cost;
        $data->fixed_cost_masters = $request->fixed_cost_masters;
        //If user Given any PHOTO
        if ($request->hasFile('logo')) {
            $data->logo = 'app/public/' . $request->file('logo')->store('Website', 'public');
        } else {
            $data->logo = $request->prev_logo;
        }

        if ($request->staff_id != $request->staff_id_old && $request->staff_id != 0) {
            //Staff
            $dataStaff = Staff::find($request->staff_id);
            if ($dataStaff->hall_id != null) {
                return redirect()->back()->with('danger', 'User is allready a Provost!');
            }
            $dataStaff->hall_id = $data->id;
            $dataStaff->save();
            //Update Previous Provost
            $dataStaff2 = Staff::find($request->staff_id_old);
            $dataStaff2->hall_id = 0;
            $dataStaff2->save();
        }
        $data->save();

        return redirect()->route('staff.settings.index')->with('success', 'Settings has been updated Successfully!');
    }
    public function roomallocationissue()
    {
        $data = RoomIssue::all()->where('hall_id', $this->hall_id);
        return view('staff.roomallocation.issue', ['data' => $data]);
    }
    public function roomallocationissueview(string $id)
    {
        //
        $data = RoomIssue::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Permitted!');
        }
        if ($data->flag != 1) {
            $data->flag = 1;
            $data->save();
        }

        return view('staff.roomallocation.issueshow', ['data' => $data]);
    }
    public function roomallocationissueaccept(string $id)
    {
        //
        $data = RoomIssue::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Permitted!');
        }
        if ($data->status == 0) {
            $data->status = 1;
            $data->staff_id = Auth::guard('staff')->user()->id;
            $data->save();
            return view('staff.roomallocation.issueshow', ['data' => $data]);
        } else {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Permitted!');
        }
    }
    public function roomallocationissuereject(string $id)
    {
        //
        $data = RoomIssue::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Permitted!');
        }
        if ($data->status == 0) {
            $data->status = 1;
            $data->staff_id = Auth::guard('staff')->user()->id;
            $data->save();
            return view('staff.roomallocation.issueshow', ['data' => $data]);
        } else {
            return redirect()->route('staff.roomallocation.issue')->with('danger', 'Not Permitted!');
        }
    }
}
