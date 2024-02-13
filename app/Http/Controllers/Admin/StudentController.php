<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hall;
use App\Models\Balance;
use App\Models\Student;
use Illuminate\Http\Request;
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
        $data->hall_id = $request->hall_id;
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
        $data->delete();
        //Delete Balance Account
        $BalanceAccount = Balance::all()->where('student_id', '=', $id)->first();
        $BalanceAccount->delete();
        return redirect('admin/student')->with('danger', 'Student data and Associated Balance Account has been deleted Successfully!');
    }

    // Import Bilk users from csv
    public function importUser()
    {
        return view('admin.student.importUser');
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
                $hall_id = $row['hall'];
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
                        'hall_id' => $hall_id,
                    ]);
                    //Creating Balance account for student
                    $BalanceController = new BalanceController();
                    $BalanceController->store($StudentData->id, $hall_id);
                    //
                    $importedStudents++;
                } else {
                    if ($data != null) {
                        $errorEmails[] = $email;
                    } else {
                        $errorEmails[] = 'rollno :' . $rollno;
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
