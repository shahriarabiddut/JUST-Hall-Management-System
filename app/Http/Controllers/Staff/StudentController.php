<?php

namespace App\Http\Controllers\Staff;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BalanceController;
use App\Models\Balance;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::all();
        return view('staff.student.index', ['data' => $data]);
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

        //Created
        $ref = $request->ref;
        if ($ref == 'front') {
            return redirect('welcome')->with('success', 'Registration Successful!' . $request->name);
        } else {
            return redirect('staff/student')->with('success', 'Data has been added Successfully!');
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
        return redirect()->route('staff.student.index')->with('success', 'Data has been updated Successfully!');
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
        $data->delete();
        //Delete Balance Account
        $BalanceAccount = Balance::all()->where('student_id', '=', $id)->first();
        $BalanceAccount->delete();
        return redirect('staff/student')->with('danger', 'Student data and Associated Balance Account has been deleted Successfully!');
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
        $errorEmails = [];
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);
                $email = $row['email'];
                $data = Student::where('email', $email)->first();
                if ($data == null) {
                    $StudentData =  Student::create([
                        'rollno' => $row['rollno'],
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'dept' => $row['dept'],
                        'session' => $row['session'],
                        'password' => bcrypt($row['email']),
                    ]);
                    //Creating Balance account for student
                    $BalanceController = new BalanceController();
                    $BalanceController->store($StudentData->id);
                } else {
                    $errorEmails[] = $email;
                }
            }
        }
        if ($errorEmails == null) {
            return redirect()->route('staff.student.index')->with('success', 'Student Data has been imported Successfully!');
        } else {
            return redirect()->route('staff.student.index')->with('success', 'Student Data has been imported Successfully!')->with('danger-email', $errorEmails);
        }
    }
}
