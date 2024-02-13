<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Room;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Student;
use App\Models\FoodTime;
use Illuminate\View\View;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use App\Models\Hall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{

    public function index()
    {
        $student_id = Auth::user()->id;
        //If remaining time is 0 , Student cannot order
        $today = Carbon::now(); // get current date and time
        $remainingTime = $today->setTimezone('GMT+6')->format('Y-m-d') . ' 22:00:00';
        $todayTime = $today->setTimezone('GMT+6')->format('Y-m-d H:i:s'); // 2023-03-17
        if ($remainingTime < $todayTime) {
            $remainingTime = 0;
        }
        //Order Data
        //checking if its tommorow
        $currentDate = Carbon::now(); // get current date and time
        $nextDate = $currentDate->addDay(); // add one day to current date
        $nextDate = $nextDate->setTimezone('GMT+6')->format('Y-m-d'); // 2023-03-17


        $resulttitle = [];
        $total_food_times = FoodTime::select('id')->where('status', '=', '1')->get();
        $results = [];
        foreach ($total_food_times as $total_food_time) {
            $i = $total_food_time->id;
            $results[] = $this->foodTime($nextDate, $i, $student_id);
            $resulttitle[] = FoodTime::all()->where('id', '=', $i)->first();
        }
        // Order Spent of Current Month
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $sumofthatmonth = Order::whereBetween('created_at', [$startDate, $endDate])->where('student_id', '=', $student_id)
            ->sum('price');

        return view('profile.dashboard', ['results' => $results, 'resulttitle' => $resulttitle, 'remainingTime' => $remainingTime, 'sumofthatmonth' => $sumofthatmonth]);
    }
    /**
     * Display the user's profile form.
     */
    public function foodTime(string $nextDate, string $id, string $student_id)
    {
        //foodtype
        $food_time = FoodTime::all()->where('status', '=', '1')->where('id', '=', $id)->first();
        //Food Item for search
        $foods = Food::all()->where('status', '=', '1')->where('food_time_id', '=', $id);
        $food_id_data = [];
        foreach ($foods as $food) {
            $food_id_data[] = $food->id;
        }

        //check ordered on that day or not 
        $check_order = Order::all()->where('date', '=', $nextDate)
            ->where('order_type', '=', $food_time->title)
            ->where('student_id', '=', $student_id);
        if (count($check_order) == 0) {
            return 0;
        }
        // total count of foods for forloop
        $total_food_count = count($foods);
        $food_data = [];
        for ($i = 1; $i <= $total_food_count; $i++) {
            $food_item_id = $food_id_data[$i - 1];
            $food_data[$i] = Order::where('date', '=', $nextDate)
                ->where('order_type', '=', $food_time->title)
                ->where('food_item_id', '=', $food_item_id)
                ->where('student_id', '=', $student_id)
                ->sum('quantity');
        }
        return [$food_data, $foods];
    }
    /**
     * Display the user's profile form.
     */
    public function view(Request $request): View
    {
        return view('profile.partials.view', [
            'user' => $request->user(),
        ]);
    }
    public function edit(Request $request): View
    {
        return view('profile.partials.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $data = Student::find($request->userid);
        $formFields = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'dept' => 'required',
            'session' => 'required',
            'email' => 'required',
        ]);
        //If user Given any PHOTO
        if ($request->hasFile('photo')) {
            $formFields['photo'] = 'app/public/' . $request->file('photo')->store('StudentPhoto', 'public');
            if (isset($request->prev_photo)) {
                $actloc = 'storage/' . $request->prev_photo;
                //Delete PHOTO from storage
                if (File::exists($actloc)) {
                    //Delete the previous photo 
                    File::delete($actloc);
                }
            }
        } else {
            $formFields['photo'] = $request->prev_photo;
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->dept = $request->dept;
        $data->session = $request->session;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->ms = $request->ms;
        $data->photo =  $formFields['photo'];

        $data->save();

        return Redirect::route('student.profile.view')->with('success', 'Profile Updated');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current-password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
    //Room Details
    public function myroom()
    {
        $userid = Auth::user()->id;
        $rooms = [];
        $data = AllocatedSeats::all()->where('user_id', '=', $userid)->first();
        if ($data) {
            $rooms = Room::all()->where('id', '=', $data->room_id)->first();
            return view('profile.room.myroom', ['data' => $data, 'rooms' => $rooms]);
        }
        return view('profile.room.myroom', ['data' => $data, 'rooms' => $rooms]);
    }
    //Room Request
    public function roomrequest()
    {
        $userid = Auth::user()->id;
        $dataAllocatedSeat = AllocatedSeats::all()->where('user_id', '=', $userid)->first();
        // IF User has Room Allocation
        if ($dataAllocatedSeat != null) {
            return redirect()->route('student.myroom');
        }
        $rooms = Room::all()->where('vacancy', '!=', 0);
        $userid = Auth::user()->id;
        $data = RoomRequest::all()->where('user_id', '=', $userid)->first();
        $halls = Hall::all();
        $sorryAllocatedSeat = 0;
        if ($data != null) {
            $sorryAllocatedSeat = 1;
        }
        return view('profile.room.roomrequest', ['halls' => $halls, 'rooms' => $rooms, 'sorryAllocatedSeat' => $sorryAllocatedSeat]);
    }
    public function roomrequeststore(Request $request)
    {
        $data = new RoomRequest;
        $request->validate([
            'hall_id' => 'required',
            'banglaname' => 'required',
            'englishname' => 'required',
            'fathername' => 'required',
            'mothername' => 'required',
            'dob' => 'required',
            'nationality' => 'required',
            'religion' => 'required',
            'maritalstatus' => 'required',
            'village' => 'required',
            'postoffice' => 'required',
            'thana' => 'required',
            'zilla' => 'required',
            'parentmobile' => 'required',
            'mobile' => 'required',
            'presentaddress' => 'required',
            'applicanthouse' => 'required',
            'occupation' => 'required',
            'department' => 'required',
            'rollno' => 'required',
            'registrationno' => 'required',
            'session' => 'required',
            'borsho' => 'required',
            'semester' => 'required',
            'dobsonod' => 'required',
            'academic' => 'required',
            'earningproof' => 'required',
            'signature' => 'required',
        ]);
        $data->hall_id = $request->hall_id;
        $data->room_id = 0;
        $data->user_id = $request->user_id;
        // New Added
        $arrayData = [];
        $arrayData['banglaname'] = $request->banglaname;
        $arrayData['englishname'] = $request->englishname;
        $arrayData['fathername'] = $request->fathername;
        $arrayData['mothername'] = $request->mothername;
        $arrayData['dob'] = $request->dob;
        $arrayData['nationality'] = $request->nationality;
        $arrayData['religion'] = $request->religion;
        $arrayData['maritalstatus'] = $request->maritalstatus;
        $arrayData['village'] = $request->village;
        $arrayData['postoffice'] = $request->postoffice;
        $arrayData['thana'] = $request->thana;
        $arrayData['zilla'] = $request->zilla;
        $arrayData['parentmobile'] = $request->parentmobile;
        $arrayData['mobile'] = $request->mobile;
        $arrayData['presentaddress'] = $request->presentaddress;
        $arrayData['applicanthouse'] = $request->applicanthouse;
        $arrayData['occupation'] = $request->occupation;
        $arrayData['ovivabok'] = $request->ovivabok;
        $arrayData['ovivabokrelation'] = $request->ovivabokrelation;
        $arrayData['ovivabokthikana'] = $request->ovivabokthikana;
        $arrayData['ovivabokmobile'] = $request->ovivabokmobile;
        $arrayData['department'] = $request->department;
        $arrayData['rollno'] = $request->rollno;
        $arrayData['registrationno'] = $request->registrationno;
        $arrayData['session'] = $request->session;
        $arrayData['borsho'] = $request->borsho;
        $arrayData['semester'] = $request->semester;
        $arrayData['culture'] = $request->culture;
        $arrayData['otisitic'] = $request->otisitic;
        //If user Given any PHOTO dobsonod , academic , earningproof , signature
        if ($request->hasFile('dobsonod')) {
            $arrayData['dobsonod'] = 'app/public/' . $request->file('dobsonod')->store('HallRequest', 'public');
        }
        if ($request->hasFile('academic')) {
            $arrayData['academic'] = 'app/public/' . $request->file('academic')->store('HallRequest', 'public');
        }
        if ($request->hasFile('earningproof')) {
            $arrayData['earningproof'] = 'app/public/' . $request->file('earningproof')->store('HallRequest', 'public');
        }
        if ($request->hasFile('signature')) {
            $arrayData['signature'] = 'app/public/' . $request->file('signature')->store('HallRequest', 'public');
        }
        $data->application = json_encode($arrayData);
        //
        $data->status = 3;
        $data->flag = 0;
        $data->save();

        return redirect()->route('student.roomrequestshow')->with('success', 'Room Alloacation Request has been added Successfully!');
    }

    public function roomrequestshow()
    {
        $userid = Auth::user()->id;
        $data = RoomRequest::all()->where('user_id', '=', $userid)->first();
        $dataPayment = Payment::all()->where('type', 'roomrequest')->where('student_id', $userid)->first();
        // page redirection
        $dataAllocatedSeats = AllocatedSeats::all()->where('user_id', '=', $userid)->first();
        if ($data != null) {
            $application = json_decode($data->application, true);

            if ($dataAllocatedSeats != null) {
                return redirect()->route('student.myroom');
            } else {
                return view('profile.room.roomrequestshow', ['data' => $data, 'application' => $application, 'dataPayment' => $dataPayment]);
            }
        } else {
            return redirect()->route('student.dashboard')->with('danger', 'No Room Alloacation Request Found!');
        }
    }
    public function roomrequestdestroy($id)
    {
        $userid = Auth::user()->id;
        // Check Room is allready allocated or not
        $dataAllocatedSeats = AllocatedSeats::all()->where('user_id', '=', $userid)->first();
        if ($dataAllocatedSeats != null) {
            return redirect()->route('student.myroom')->with('danger', 'Access Denied!');
        }
        //
        $data = RoomRequest::find($id);
        $data->delete();
        return Redirect::to('student/rooms/requestshow')->with('danger', 'Room Alloacation Request has been Deleted!');
    }
    public function roomrequestpaymentdestroy($id)
    {
        $userid = Auth::user()->id;
        // Check Room is allready allocated or not
        $dataAllocatedSeats = AllocatedSeats::all()->where('user_id', '=', $userid)->first();
        if ($dataAllocatedSeats != null) {
            return redirect()->route('student.myroom')->with('danger', 'Access Denied!');
        }
        //
        $data = Payment::find($id);
        if ($data == null) {
            return redirect()->route('student.roomrequestshow')->with('danger', 'Access Denied!');
        }
        if ($data->student_id != $userid) {
            return redirect()->route('student.roomrequestshow')->with('danger', 'Access Denied! Warning!');
        }
        if ($data->status == 'Accepted') {
            return redirect()->route('student.roomrequestshow')->with('danger', 'Access Denied! Payment Allready Accepted!');
        }
        $data->delete();
        return Redirect::to('student/rooms/requestshow')->with('danger', 'Room Alloacation Request Payment has been Deleted!');
    }
    //Edit Room Request
    public function roomrequestedit(string $id)
    {
        $rooms = Room::all()->where('vacancy', '!=', 0);
        $userid = Auth::user()->id;
        $data = RoomRequest::all()->where('user_id', '=', $userid)->first();
        // Check Room is allready allocated or not
        $dataAllocatedSeats = AllocatedSeats::all()->where('user_id', '=', $userid)->first();
        if ($dataAllocatedSeats != null) {
            $sorryAllocatedSeat = 2;
        } elseif ($data != null) {
            $sorryAllocatedSeat = 1;
        } else {
            $sorryAllocatedSeat = 0;
        }
        return view('profile.room.roomrequestedit', ['rooms' => $rooms, 'sorryAllocatedSeat' => $sorryAllocatedSeat, "data" => $data]);
    }
    public function roomrequestupdate(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'message' => 'required',
        ]);
        $data = RoomRequest::all()->where('user_id', '=', $request->user_id)->where('id', '=', $request->id)->first();
        $data->room_id = $request->room_id;
        $data->message = $request->message;
        $data->save();

        return redirect()->route('student.roomrequestshow')->with('success', 'Room Alloacation Request has been added Successfully!');
    }
    // Add Payment
    public function roomrequestpayment()
    {
        $userid = Auth::user()->id;
        $data = RoomRequest::all()->where('user_id', '=', $userid)->first();
        $dataPayment = Payment::all()->where('type', 'roomrequest')->where('student_id', $userid)->first();
        // IF User has Room Allocation
        if ($dataPayment != null) {
            return redirect()->route('student.roomrequestshow');
        }
        return view('profile.room.roomrequestpayment', ['dataPayment' => $dataPayment]);
    }
    public function roomrequestpaymentstore(Request $request)
    {
        $data = new Payment;
        $request->validate([
            'proof' => 'required',
            'amount' => 'required',
        ]);
        $imgPath = $request->proof->store('PaymentSlips', 'public');
        $data->proof = 'app/public/' . $imgPath;
        $data->student_id = $request->user_id;
        $data->transaction_id = 0;
        $data->phone = $request->mobileno;
        $data->amount = $request->amount;
        $data->status = 'Processing';
        $data->name = Auth::user()->name;
        $data->email = Auth::user()->email;
        $data->address = 'Bank Payment';
        $data->currency = 'BDT';
        $data->type = 'roomrequest';
        $data->phone = $request->mobileno;
        $data->save();

        return redirect()->route('student.roomrequestshow')->with('success', 'Room Alloacation Request Payment has been added Successfully!');
    }
    /**
     * Update the user's password information.
     */
    public function editPassword(Request $request): View
    {
        return view('profile.partials.changePassword', [
            'user' => $request->user(),
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
        $data = Student::find($request->userid);
        $oldPass = $data->password;
        $currentPassword = $request->currentPassword;
        if (Hash::check($currentPassword, $oldPass)) {
            //If user Given confirm poassword same
            $data->password = bcrypt(($request->newPassword));
            $data->save();
            return Redirect::route('student.profile.view')->with('success', 'Password Updated Succesfully!');
        } else {
            return Redirect::back()->with('danger', "Current Password Didn't Match");
        }
    }
}
