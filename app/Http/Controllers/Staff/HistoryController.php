<?php

namespace App\Http\Controllers\Staff;

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
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
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
        return view('staff.history.index', ['data' => $data]);
    }
    public function show(string $id)
    {
        //
        $data = History::find($id);
        if ($data == null) {
            return redirect()->route('staff.history.index')->with('danger', 'Not Found!');
        }
        if ($data->status != 1) {
            $data->status = 1;
            $data->save();
        }
        return view('staff.history.show', ['data' => $data]);
    }
    public function read()
    {
        $data = History::all()->where('status', '0');
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
}
