<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Balance;
use App\Models\Student;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use App\Http\Controllers\BalanceController;

class StudentController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::guard('staff')->user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null || Auth::guard('staff')->user()->status == 0) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            }
            if (Auth::guard('staff')->user()->hall_id != 0) {
                if (Auth::guard('staff')->user()->hall->status == 0) {
                    return redirect()->route('staff.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
                }
            }
            if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'aprovost') {
                return $next($request);
                // return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            } else {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
                return $next($request);
            }
        });
    }
    // Command To Deduct Fixed Meal Cost from staff
    public function deductBalanceStaff()
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $result = Process::run('php artisan deduct:balance ' . $this->hall_id);
        //Saving History 
        $HistoryController = new HistoryController();
        $today = Carbon::now();
        $HistoryController->addHistoryHall(Auth::guard('staff')->user()->id, 'Fixed Cost Charge', 'Fixed Cost Charged for Month ' . $today->format('F') . '!', $this->hall_id);
        //Saved
        return redirect()->route('staff.balance.index')->with('success', 'Fixed Cost Charged Successfully!');
    }

    public function index()
    {

        $data = Student::all()->where('hall_id', $this->hall_id);
        return view('staff.student.index', ['data' => $data]);
    }
    public function search(Request $request)
    {
        // dd($request);
        $type = $request->type;
        $data = Student::all()->where('hall_id', $this->hall_id);
        if ($request->type != '' && $request->type != '2') {
            $data = $data->where('ms',  $type);
        }
        return view('staff.student.search', ['data' => $data, 'type' => $type,]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        return view('staff.student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = new Student;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:users',
            'password' => 'required | min:6',
            'mobile' => 'required',
            'rollno' => 'required|unique:users',
            'dept' => 'required',
            'session' => 'required',
            'gender' => 'required|not_in:3',
        ]);
        $data->name = $request->name;
        $data->dept = $request->dept;
        $data->session = $request->session;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->rollno = $request->rollno;
        $data->ms = $request->ms;
        $data->gender = $request->gender;
        $data->hall_id = $this->hall_id;
        $data->status = 1;
        //If user Given address
        if ($request->has('address')) {
            $data->address = $request->address;
        }
        //If user Given any PHOTO
        if ($request->hasFile('photo')) {
            $data->photo = 'app/public/' . $request->file('photo')->store('StudentPhoto', 'public');
        }
        //Hash Password
        $data->password = bcrypt(($request->password));

        $data->save();
        //Creating Balance account for student
        $BalanceController = new BalanceController();
        $BalanceController->store($data->id, $this->hall_id);
        //
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'add', 'Student (' . $data->rollno . ' ) - ' . $data->name . ' has been added Successfully!', $this->hall_id);
        //Saved
        //Created
        return redirect()->route('staff.student.index')->with('success', 'Student has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.student.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.student.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = Student::find($id);
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Permitted!');
        }
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|email',
            'mobile' => 'required',
            'rollno' => 'required',
            'dept' => 'required',
            'session' => 'required',
        ]);
        $data->name = $request->name;
        $data->dept = $request->dept;
        $data->session = $request->session;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->rollno = $request->rollno;
        $data->gender = $request->gender;
        $data->ms = $request->ms;
        //If user Given address
        if ($request->has('address')) {
            $data->address = $request->address;
        }
        //If user Given any PHOTO
        if ($request->hasFile('photo')) {
            $data->photo = 'app/public/' . $request->file('photo')->store('StudentPhoto', 'public');
        } else {
            $data->photo = $request->prev_photo;
        }
        $data->update();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'update', 'Student (' . $data->rollno . ' ) - ' . $data->name . ' has been updated Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.student.index')->with('success', 'Student has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Permitted!');
        }
        // Balance Account
        $BalanceAccount = Balance::all()->where('student_id', '=', $id)->first();
        // Iff Allocated Seat
        $AllocatedSeat = AllocatedSeats::all()->where('user_id', '=', $id)->first();
        // Iff Room Request Found
        $RoomRequest = RoomRequest::all()->where('user_id', '=', $id)->first();
        if ($RoomRequest != null) {
            $RoomRequest->delete();
        }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        if ($AllocatedSeat != null) {
            $HistoryController->addHistoryHall($staff_id, 'delete', 'Student (' . $data->rollno . ' ) - ' . $data->name . '  and Associated Balance Account has been disabled Successfully! Last Balance was ' . $BalanceAccount->balance_amount . ' . And Allocated Seat no was ' . $AllocatedSeat->position . ' in Room No ' . $AllocatedSeat->rooms->title . ' .', $this->hall_id);
            $AllocatedSeat->status = 0;
            $AllocatedSeat->save();

            // Room Vacancy + 1
            $roomid = $AllocatedSeat->room_id;
            $room = Room::find($roomid);
            $roomVacant = $room->vacancy + 1;
            $room->vacancy = $roomVacant;
            //Room Vancacy Readded
            // Add The position back to Room Positions
            $arrayRepresentation = json_decode($room->positions, true);
            array_push($arrayRepresentation, $AllocatedSeat->position);
            sort($arrayRepresentation);
            $jsonData = json_encode($arrayRepresentation);
            $room->positions = $jsonData;
            //
            $room->save();

            // $data->hall_id = 0;
            // $BalanceAccount->hall_id = 0;
        } else {
            $HistoryController->addHistoryHall($staff_id, 'delete', 'Student (' . $data->rollno . ' ) - ' . $data->name . '  and Associated Balance Account has been disabled Successfully! Last Balance was ' . $BalanceAccount->balance_amount . ' . And No seat was Allocated.', $this->hall_id);
        }
        //Saved
        $data->status = 0;
        $data->save();
        $BalanceAccount->status = 0;
        $BalanceAccount->save();
        return redirect()->route('staff.student.index')->with('danger', 'Student data and Associated Balance Account and Allocation data has been disabled Successfully!');
    }

    // Import Bilk users from csv
    public function importUser()
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        return view('staff.student.importUser');
    }

    public function handleImportUser(Request $request)
    {
        if (Auth::guard('staff')->user()->hall_id != 0) {
            $gender = Auth::guard('staff')->user()->hall->type;
        } else {
            $gender = 'N/A';
        }

        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $validator = $request->validate([
            'file' => 'required',
        ]);
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);
        $length = count($rows);
        $importedStudents = 0;
        $errorEmails = [];
        // dd( $rows);
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);
                if (isset($row['email'])) {
                    $email = $row['email'];
                }
                $rollno = $row['rollno'];
                if ($request->email != 2 && isset($row['mobile'])) {
                    $mobile = preg_replace('/\D/', '', $row['mobile']);
                } else {
                    $mobile = 0;
                }

                // dd($mobile);
                //check ms or not
                if (preg_match('/^\d+$/', $rollno)) {
                    $ms = 0;
                } else {
                    $ms = 1;
                }
                //
                $rollnoMain = str_replace(' ', '', $rollno);
                if (isset($row['email'])) {
                    $data = Student::where('email', $email)->first();
                    $data2 = Student::where('rollno', $rollnoMain)->first();
                } else {
                    $data = Student::where('rollno', $rollnoMain)->first();
                    $data2 = $data;
                }
                if ($data == null && $data2 == null) {
                    if ($data2 == null) {
                        $StudentData =  new Student();
                        $StudentData->name = $row['name'];
                        $StudentData->dept = $row['dept'];
                        $StudentData->session = $row['session'];
                        if ($request->email >= 1) {
                            $StudentData->email = $email;
                        }
                        $StudentData->mobile = $mobile;
                        $StudentData->rollno = $rollnoMain;
                        $StudentData->password = bcrypt($row['rollno']);
                        $StudentData->ms = $ms;
                        $StudentData->gender = $gender;
                        $StudentData->hall_id = $this->hall_id;
                        $StudentData->status = 1;
                        $StudentData->save();
                        //Creating Balance account for student
                        $BalanceController = new BalanceController();
                        $BalanceController->store($StudentData->id, $this->hall_id);
                        //
                        $importedStudents++;
                        // Add History 
                        $HistoryController = new HistoryController();
                        $staff_id = Auth::guard('staff')->user()->id;
                        $HistoryController->addHistoryHall($staff_id, 'add', 'Student (' . $StudentData->rollno . ' ) - ' . $StudentData->name . ' have been added Successfully!', $this->hall_id);
                        //Saved
                    }
                } else {

                    if (isset($row['email'])) {
                        $errorEmails[] = $email;
                    } else {
                        $errorEmails[] = 'rollno :' . $rollno;
                    }
                }
            }
        }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'add', 'Total ' . $importedStudents . ' Student have been imported Successfully!', $this->hall_id);
        //Saved
        if ($errorEmails == null) {
            return redirect()->route('staff.student.index')->with('success', 'Total ' . $importedStudents . ' Student Data have been imported Successfully!');
        } else {
            return redirect()->route('staff.student.index')->with('success', 'Total ' . $importedStudents . ' Student Data have been imported Successfully!')->with('danger-email', $errorEmails);
        }
    }
}
