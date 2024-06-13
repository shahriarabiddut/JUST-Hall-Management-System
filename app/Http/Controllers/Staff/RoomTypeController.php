<?php

namespace App\Http\Controllers\Staff;

use App\Models\RoomType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomTypeController extends Controller
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
            if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost') {
                return $next($request);
            } else {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
                return $next($request);
            }
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = RoomType::all();
        return view('staff.roomType.index', ['data' => $data]);
    }
    public function show(string $id)
    {
        //
        $data = RoomType::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomtype.index')->with('danger', 'Not Found!');
        }
        return view('staff.roomType.show', ['data' => $data]);
    }
}
