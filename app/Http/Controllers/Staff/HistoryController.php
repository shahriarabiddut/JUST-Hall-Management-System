<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
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
        $data = History::latest()->where('hall_id', $this->hall_id)->get();
        $staff = Staff::all()->where('hall_id', $this->hall_id);
        return view('staff.history.index', ['data' => $data, 'staff' => $staff]);
    }
    public function show(string $id)
    {
        //
        $data = History::find($id);
        if ($data == null) {
            return redirect()->route('staff.history.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.history.index')->with('danger', 'Not Permitted!');
        }
        if ($data->status != 1) {
            $data->status = 1;
            $data->save();
        }
        return view('staff.history.show', ['data' => $data]);
    }
    public function read()
    {
        $data = History::all()->where('status', '0')->where('hall_id', $this->hall_id);
        foreach ($data as $d) {
            $data2 = History::find($d->id);
            $data2->status = 1;
            $data2->save();
        }
        return redirect()->route('staff.history.index')->with('success', 'Marked As Read!');
    }
    public function addHistory(string $staff_id, string $flag, string $data)
    {
        //
        $dataHistory = new History();
        $dataHistory->staff_id = $staff_id;
        $dataHistory->data = $data;
        $dataHistory->flag = $flag;
        $dataHistory->status = 0;
        $dataHistory->save();
    }
    public function addHistoryHall(string $staff_id, string $flag, string $data, string $hall_id)
    {
        //
        $dataHistory = new History();
        $dataHistory->staff_id = $staff_id;
        $dataHistory->data = $data;
        $dataHistory->flag = $flag;
        $dataHistory->status = 0;
        $dataHistory->hall_id = $hall_id;
        $dataHistory->save();
    }
    public function searchByMonth(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|not_in:x',
            'month' => 'required',
        ]);
        $staff = Staff::all();
        $staffData = Staff::find($request->staff_id);
        $dataMo = [];
        foreach (explode('-', $request->month) as $dataMonth) {
            $dataMo[] = $dataMonth;
        }
        $year = $dataMo[0]; // Replace with the year you want to search for
        $month = $dataMo[1];   // Replace with the month you want to search for
        $SearchData = $request->month;   // Replace with the month you want to search for
        $data = History::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('staff_id', '=', $request->staff_id)
            ->where('hall_id', $this->hall_id)
            ->get();

        return view('staff.history.searchMonth', ['data' => $data, 'staffData' => $staffData, 'staff' => $staff, 'month' => $SearchData, 'message' => '0']);
    }
    public function readSearch(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|not_in:x',
            'month' => 'required',
        ]);
        $staff = Staff::all();
        $staffData = Staff::find($request->staff_id);
        $dataMo = [];
        foreach (explode('-', $request->month) as $dataMonth) {
            $dataMo[] = $dataMonth;
        }
        $year = $dataMo[0]; // Replace with the year you want to search for
        $month = $dataMo[1];   // Replace with the month you want to search for
        $SearchData = $request->month;   // Replace with the month you want to search for
        $data = History::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('staff_id', '=', $request->staff_id)
            ->where('hall_id', $this->hall_id)
            ->get();
        foreach ($data as $d) {
            $data2 = History::find($d->id);
            $data2->status = 1;
            $data2->save();
        }
        $data = History::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('staff_id', '=', $request->staff_id)
            ->where('hall_id', $this->hall_id)
            ->get();
        return view('staff.history.searchMonth', ['data' => $data, 'staffData' => $staffData, 'staff' => $staff, 'month' => $SearchData, 'message' => '1']);
    }
    public function chartData()
    {
        $currentMonth = Carbon::now()->month;
        //Provost Dashboard - bar chart
        $histories = History::where('hall_id', $this->hall_id)->whereMonth('created_at', $currentMonth)->get();
        $staff = [];
        foreach ($histories as $history) {
            if (isset($staff[$history->staff_id])) {
                $staff[$history->staff_id]++;
            } else {
                $staff[$history->staff_id] = 1;
            }
        }
        $labelStaff = [];
        $labelStaff['N/A'] = 0;
        foreach ($staff as $key => $staffData) {
            $labelStaffDummy = Staff::find($key);
            if ($labelStaffDummy->name != null) {
                $labelStaff[$labelStaffDummy->name] = $staff[$key];
            } else {
                $labelStaff['N/A'] = $labelStaff['N/A'] + $staff[$key];
            }
        }
        if ($labelStaff['N/A'] == 0) {
            unset($labelStaff['N/A']);
        }
        //

        return response()->json($labelStaff);
    }
}
