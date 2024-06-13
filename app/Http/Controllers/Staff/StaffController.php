<?php

namespace App\Http\Controllers\Staff;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
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
            if (Auth::guard('staff')->user()->type == 'provost') {
                return $next($request);
                // return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            } else {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
                return $next($request);
            }
        });
    }
    public function index()
    {
        $data = Staff::all()->where('hall_id', $this->hall_id);
        return view('staff.staff.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('staff.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Staff;
        $request->validate([
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:staff',
            'type' => 'required|not_in:0',
        ]);
        $data->email = $request->email;
        $data->password = bcrypt($request->email);
        $data->type = $request->type;
        $data->hall_id = $this->hall_id;
        $data->status = 1;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'add staff', 'Staff (' . $data->type . ' ) - ' . $data->name . ' has been added Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.staff.index')->with('success', 'Staff has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.staff.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.staff.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = Staff::find($id);
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Permitted!');
        }
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $data->name = $request->name;
        $data->bio = $request->bio;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->type = $request->type;
        //If user Gieven any PHOTO
        if ($request->hasFile('photo')) {
            $imgpath = 'app/public/' . $request->file('photo')->store('StaffPhoto', 'public');
        } else {
            $imgpath = $request->prev_photo;
        }
        $data->photo =  $imgpath;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'update staff', 'Staff (' . $data->type . ' ) - ' . $data->name . ' has been updated Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.staff.index')->with('success staff', 'Staff (' . $data->name . ') data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Permitted!');
        }
        $data->status = 0;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'remove staff', 'Staff (' . $data->type . ' ) - ' . $data->name . ' has been removed Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.staff.index')->with('danger', 'Staff Data has been removed from hall Successfully!');
    }

    public function change(string $id)
    {
        //
        $data = Staff::find($id);
        if ($data == null) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.staff.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.staff.change', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeUpdate(Request $request, $id)
    {
        //
        $data = Staff::find($id);
        $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();

        return redirect()->route('staff.staff.index')->with('success staff', 'Staff (' . $data->name . ') Email & Password has been updated Successfully!');
    }
}
