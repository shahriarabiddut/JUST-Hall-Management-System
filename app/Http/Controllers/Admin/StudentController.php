<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hall;
use App\Models\Room;
use App\Models\Balance;
use App\Models\Student;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BalanceController;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::all();
        return view('admin.student.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $halls = Hall::all();
        return view('admin.student.create', ['halls' => $halls]);
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
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:users',
            'password' => 'required | min:6',
            'mobile' => 'required',
            'rollno' => 'required|unique:users',
            'dept' => 'required|not_in:0',
            'session' => 'required|not_in:0',
        ]);
        $data->name = $request->name;
        $data->dept = $request->dept;
        $data->session = $request->session;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->rollno = $request->rollno;
        $data->ms = $request->ms;
        $data->hall_id = $request->hall_id;
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
        $BalanceController->store($data->id, $data->hall_id);

        //Created
        $ref = $request->ref;
        if ($ref == 'front') {
            return redirect('welcome')->with('success', 'Registration Successful!' . $request->name);
        } else {
            return redirect('admin/student')->with('success', 'Data has been added Successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('admin.student.index')->with('danger', 'Not Found!');
        }
        return view('admin.student.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Student::find($id);
        $halls = Hall::all();
        if ($data == null) {
            return redirect()->route('admin.student.index')->with('danger', 'Not Found!');
        }
        if ($data->hall != null) {
            if ($data->hall->enable_delete == 0) {
                return redirect()->route('admin.student.index')->with('danger', 'Not Permitted!');
            }
        }
        return view('admin.student.edit', ['data' => $data, 'halls' => $halls]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //
        $data = Student::find($id);
        if ($data->hall_id != $request->hall_id) {
            // Balance Account Hall Update
            $BalanceAccount = Balance::all()->where('student_id', '=', $data->id)->first();
            $BalanceAccount->hall_id = $request->hall_id;
            $BalanceAccount->save();
        }
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i',
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
        $data->hall_id = $request->hall_id;
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
        return redirect()->route('admin.student.index')->with('success', 'Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('admin.student.index')->with('danger', 'Not Found!');
        }
        if ($data->hall != null) {
            if ($data->hall->enable_delete == 0) {
                return redirect()->route('admin.student.index')->with('danger', 'Not Permitted!');
            }
        }
        if ($data->status == 0) {
            return redirect()->route('admin.student.index')->with('danger', 'No Action Needed!');
        }
        //Delete Balance Account
        $BalanceAccount = Balance::all()->where('student_id', '=', $id)->first();
        $data->status = 0;
        $data->save();
        $BalanceAccount->status = 0;
        $BalanceAccount->save();
        // Iff Allocated Seat
        $AllocatedSeat = AllocatedSeats::all()->where('user_id', '=', $id)->first();
        // Iff Room Request Found
        $RoomRequest = RoomRequest::all()->where('user_id', '=', $id)->first();
        if ($RoomRequest != null) {
            $RoomRequest->delete();
        }
        if ($AllocatedSeat != null) {
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
        }
        return redirect('admin/student')->with('danger', 'Student data and Associated Balance Account has been disabled Successfully!');
    }
    public function activate($id)
    {
        $data = Student::find($id);
        if ($data == null) {
            return redirect()->route('admin.student.index')->with('danger', 'Not Found!');
        }
        if ($data->status == 1) {
            return redirect()->route('admin.student.index')->with('danger', 'No Action Needed!');
        }
        if ($data->hall != null) {
            if ($data->hall->enable_delete == 0) {
                return redirect()->route('admin.student.index')->with('danger', 'Not Permitted!');
            }
        }
        //Delete Balance Account
        $BalanceAccount = Balance::all()->where('student_id', '=', $id)->first();
        $data->status = 1;
        $data->save();
        $BalanceAccount->status = 1;
        $BalanceAccount->save();
        return redirect()->route('admin.student.index')->with('success', 'Student data and Associated Balance Account has been activated Successfully!');
    }
    // Import Bilk users from csv
    public function importUser()
    {
        $hall = Hall::all()->where('status', 1);
        return view('admin.student.importUser', ['halls' => $hall]);
    }

    public function handleImportUser(Request $request)
    {
        $validator = $request->validate([
            'file' => 'required',
            'hall_id' => 'required|not_in:0',
            'email' => 'required',
        ]);
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);
        $length = count($rows);
        $importedStudents = 0;
        $errorEmails = [];
        $hall_id = $request->hall_id;
        $hall = Hall::find($hall_id);
        $gender = $hall->type;
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);
                if ($request->email) {
                    $email = $row['email'];
                }
                $rollno = $row['rollno'];
                if ($request->email == 1 || $request->email == 0) {
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
                if ($request->email) {
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
                        if ($request->email) {
                            $StudentData->email = $email;
                        }
                        $StudentData->mobile = $mobile;
                        $StudentData->rollno = $rollnoMain;
                        $StudentData->password = bcrypt($row['rollno']);
                        $StudentData->ms = $ms;
                        $StudentData->gender = $gender;
                        $StudentData->hall_id = $hall_id;
                        $StudentData->status = 1;
                        $StudentData->save();
                        //Creating Balance account for student
                        $BalanceController = new BalanceController();
                        $BalanceController->store($StudentData->id, $hall_id);
                        //
                        $importedStudents++;
                    } else {
                        if ($data != null && $request->email) {
                            $errorEmails[] = $email;
                        } else {
                            $errorEmails[] = 'rollno :' . $rollno;
                        }
                    }
                }
            }
        }
        if ($errorEmails == null) {
            return redirect()->route('admin.student.index')->with('success', 'Total ' . $importedStudents . ' Student Data have been imported Successfully!');
        } else {
            return redirect()->route('admin.student.index')->with('success', 'Total ' . $importedStudents . ' Student Data have been imported Successfully!')->with('danger-email', $errorEmails);
        }
    }
}
