<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
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
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('staff')->user()->type == 'provost') {
                return $next($request);
                // return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            } elseif (Auth::guard('staff')->user()->type == 'aprovost') {
                return $next($request);
            } else {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
                return $next($request);
            }
        });
    }
    // Command To Deduct Fixed Meal Cost from staff
    public function deductBalanceStaff()
    {
        $result = Process::run('php artisan send:sms');
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $today = Carbon::now();
        $HistoryController->addHistory($staff_id, 'Fixed Cost Charge', 'Fixed Cost Charged for Month ' . $today->format('F') . '!');
        //Saved
        return redirect()->route('staff.balance.index')->with('success', 'Fixed Cost Charged Successfully!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Student::all();
        return view('staff.student.index', ['data' => $data]);
    }
    public function search(Request $request)
    {
        // dd($request);
        $type = $request->type;
        $data = Student::all();
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
        return view('staff.student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Student;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required | min:6',
            'mobile' => 'required',
            'rollno' => 'required|unique:users',
            'dept' => 'required',
            'session' => 'required',
        ]);
        $data->name = $request->name;
        $data->dept = $request->dept;
        $data->session = $request->session;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->rollno = $request->rollno;
        $data->ms = $request->ms;

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
        $BalanceController->store($data->id);
        //
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'add', 'Student (' . $data->rollno . ' ) - ' . $data->name . ' has been added Successfully!');
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
        return view('staff.student.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Found!');
        }

        return view('staff.student.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = Student::find($id);
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
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
        $HistoryController->addHistory($staff_id, 'update', 'Student (' . $data->rollno . ' ) - ' . $data->name . ' has been updated Successfully!');
        //Saved
        return redirect()->route('staff.student.index')->with('success', 'Student has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('staff.student.index')->with('danger', 'Not Found!');
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
            $HistoryController->addHistory($staff_id, 'delete', 'Student (' . $data->rollno . ' ) - ' . $data->name . '  and Associated Balance Account has been deleted Successfully! Last Balance was ' . $BalanceAccount->balance_amount . ' . And Allocated Seat no was ' . $AllocatedSeat->position . ' in Room No ' . $AllocatedSeat->rooms->title . ' .');
            $AllocatedSeatController = new AllocatedSeatController();
            $AllocatedSeatController->destroy($AllocatedSeat->id);
        } else {
            $HistoryController->addHistory($staff_id, 'delete', 'Student (' . $data->rollno . ' ) - ' . $data->name . '  and Associated Balance Account has been deleted Successfully! Last Balance was ' . $BalanceAccount->balance_amount . ' . And No seat was Allocated.');
        }
        //Saved
        $data->delete();
        $BalanceAccount->delete();
        return redirect()->route('staff.student.index')->with('danger', 'Student data and Associated Balance Account and Allocation data has been deleted Successfully!');
    }

    // Import Bilk users from csv
    public function importUser()
    {
        return view('staff.student.importUser');
    }

    public function handleImportUser(Request $request)
    {
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
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);
                // dd($row);
                $email = $row['email'];
                $rollno = $row['rollno'];
                //check ms or not
                if (preg_match('/^\d+$/', $rollno)) {
                    $ms = 0;
                } else {
                    $ms = 1;
                }
                //
                $rollnoMain = str_replace(' ', '', $rollno);
                $data = Student::where('email', $email)->first();
                $data2 = Student::where('rollno', $rollnoMain)->first();
                if ($data == null && $data2 == null) {
                    $StudentData =  Student::create([
                        'rollno' => $rollnoMain,
                        'name' => $row['name'],
                        'email' => $email,
                        'dept' => $row['dept'],
                        'session' => $row['session'],
                        'ms' => $ms,
                        'password' => bcrypt($row['rollno']),
                    ]);
                    //Creating Balance account for student
                    $BalanceController = new BalanceController();
                    $BalanceController->store($StudentData->id);
                    //
                    $importedStudents++;
                    // Add History 
                    $HistoryController = new HistoryController();
                    $staff_id = Auth::guard('staff')->user()->id;
                    $HistoryController->addHistory($staff_id, 'add', 'Student (' . $StudentData->rollno . ' ) - ' . $StudentData->name . ' have been added Successfully!');
                    //Saved
                } else {
                    if ($data != null) {
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
        $HistoryController->addHistory($staff_id, 'add', 'Total ' . $importedStudents . ' Student have been imported Successfully!');
        //Saved
        if ($errorEmails == null) {
            return redirect()->route('staff.student.index')->with('success', 'Total ' . $importedStudents . ' Student Data have been imported Successfully!');
        } else {
            return redirect()->route('staff.student.index')->with('success', 'Total ' . $importedStudents . ' Student Data have been imported Successfully!')->with('danger-email', $errorEmails);
        }
    }
}
