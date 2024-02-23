<?php

namespace App\Http\Controllers;

use App\Models\Support;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Staff\HistoryController;

class SupportController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('student.dashboard')->with('danger', 'Please Get Hall Room Allocation to get access!');
            }
            if (Auth::user()->hall->status == 0) {
                return redirect()->route('student.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
            }
            return $next($request);
        });
    }
    public function index()
    {

        //
        $user_id = Auth::user()->id;
        $data = Support::all()->where('user_id', '=', $user_id);
        return view('profile.support.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('profile.support.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new Support;
        $user_id = Auth::user()->id;
        $request->validate([
            'category' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $data->user_id = $user_id;
        $data->category = $request->category;
        $data->subject = $request->subject;
        $data->message = $request->message;
        $data->hall_id = Auth::user()->hall_id;
        $data->save();

        return redirect('student/support')->with('success', 'Support Ticket has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Support::find($id);
        if ($data == null) {
            return redirect()->route('student.support.index')->with('danger', 'Not Found');
        }
        return view('profile.support.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    //     $data = Support::find($id);
    //     //header And Sidebar
    //     $dataMessage = $this->messageHeader();
    //     $sorryRoomSidebar = $this->roomSidebar();
    //     //header And Sidebar
    //     return view('student.support.edit',['data' => $data,'dataMessage'=>$dataMessage,'sorryRoomSidebar'=>$sorryRoomSidebar]);
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    //     $data = Support::find($id);

    //     $request->validate([
    //     'category' => 'required',
    //     'subject' => 'required',
    //     'message' => 'required',
    //     ]);
    //     $data->category = $request->category;
    //     $data->subject = $request->subject;
    //     $data->message = $request->message;
    //     $data->save();

    //     return redirect('student/support')->with('success','Support Ticket has been Updated Successfully!');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = Support::find($id);
        if ($data->status != null || $data->status != 0) {
            return redirect('student/support')->with('danger', 'You cannot delete Support Ticket!');
        } else {
            $data->delete();
            return redirect('student/support')->with('danger', 'Support Ticket has been Deleted Successfully!');
        }
    }
}
