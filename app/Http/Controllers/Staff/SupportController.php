<?php

namespace App\Http\Controllers\Staff;

use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Staff\HistoryController;

class SupportController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::guard('staff')->user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            }
            return $next($request);
        });
    }
    //
    public function index()
    {
        //
        $data = Support::all()->where('hall_id', $this->hall_id);
        return view('staff.support.index', ['data' => $data]);
    }
    public function show(string $id)
    {
        //
        $data = Support::find($id);
        if ($data == null) {
            return redirect()->route('staff.support.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.support.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.support.show', ['data' => $data]);
    }
    public function reply(string $id)
    {
        //
        $data = Support::find($id);
        if ($data == null) {
            return redirect()->route('staff.support.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.support.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.support.reply', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        //
        $data = Support::find($id);
        $request->validate([
            'reply' => 'required',
            'status' => 'required',
        ]);
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.support.index')->with('danger', 'Not Permitted!');
        }
        $data->reply = $request->reply;
        $data->status = $request->status;
        $data->repliedby = Auth::guard('staff')->user()->id;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'support Reply', 'Staff (' . $data->staff->name . ' ) Replied to Student (' . $data->student->rollno . ' ) - ' . $data->student->name . ' , Support Ticket!', $this->hall_id);
        //Saved
        return redirect('staff/support')->with('success', 'Support Ticket has been Replied Successfully!');
    }
}
