<?php

namespace App\Http\Controllers\Staff;

use App\Models\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
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
    //Staff Index
    public function index()
    {
        //
        $data = Balance::all()->where('hall_id', $this->hall_id);
        return view('staff.balance.index', ['data' => $data]);
    }
}
