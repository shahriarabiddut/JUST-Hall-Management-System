<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use App\Http\Controllers\Controller;
use App\Models\RoomRequest;
use Illuminate\Support\Facades\DB;


class AllocatedSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AllocatedSeats::all();
        return view('admin.roomallocation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Student Data segregation
        $unstudents = DB::select("SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM allocated_seats)");
        $data = [];
        foreach ($unstudents as $student) {
            $data[] = $student;
        }
        $students = $data;
        //Room Data segregation
        $rooms = Room::all()->where('vacancy', '!=', 0);
        return view('admin.roomallocation.create', ['students' => $students, 'rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = new AllocatedSeats;
        $request->validate([
            'room_id' => 'required',
            'user_id' => 'required',
            'position' => 'required',
        ]);


        $data->room_id = $request->room_id;
        $data->user_id = $request->user_id;
        $data->position = $request->position;
        $data->save();
        // Room Vacancy - 1
        $roomid = $request->room_id;
        $room = Room::find($roomid);
        $roomVacant = $room->vacancy - 1;
        $room->vacancy = $roomVacant;
        $room->save();
        // Room Vancacy deleted

        return redirect('admin/roomallocation')->with('success', 'AllocatedSeats Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        return view('admin.roomallocation.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $students = Student::all();
        $rooms = Room::all();
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        return view('admin.roomallocation.edit', ['data' => $data, 'students' => $students, 'rooms' => $rooms]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = AllocatedSeats::find($id);

        $request->validate([
            'room_id' => 'required',
            'user_id' => 'required',
            'position' => 'required',
        ]);

        $data->room_id = $request->room_id;
        $data->user_id = $request->user_id;
        $data->position = $request->position;
        $data->save();

        return redirect('admin/roomallocation')->with('success', 'AllocatedSeats Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        // Room Vacancy + 1
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        $roomVacant = $room->vacancy + 1;
        $room->vacancy = $roomVacant;
        $room->save();
        // Room Vancacy Readded
        $data->delete();
        return redirect('admin/roomallocation')->with('danger', 'Data has been deleted Successfully!');
    }
    //Room Allocation Requests
    public function roomrequests()
    {
        $data = RoomRequest::orderBy('created_at', 'desc')->get();
        return view('admin.roomallocation.requests', ['data' => $data]);
    }
    //Room Allocation Requests Details
    public function showRoomRequest(string $id)
    {
        //
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $student_id = $data->user_id;
        $data2 = Student::find($student_id);
        if ($data) {
            return view('admin.roomallocation.roomrequestshow', ['data' => $data, 'data2' => $data2]);
        } else {
            return redirect('admin/roomallocation')->with('danger', 'No Data Found');
        }
    }
    //Room Allocation Requests Details
    public function RoomRequestAllocate(string $id)
    {
        //
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $student_id = $data->user_id;
        $room_id = $data->room_id;
        $data2 = Student::find($student_id);
        if ($data) {
            //Allocating seat 
            $data3 = new AllocatedSeats;
            $data3->room_id = $room_id;
            $data3->user_id = $student_id;
            $data3->position = 0;

            $data3->save();
            // Room Vacancy - 1
            $roomid = $room_id;
            $room = Room::find($roomid);
            $roomVacant = $room->vacancy - 1;
            $room->vacancy = $roomVacant;
            $room->save();
            // Room Vancacy deleted

            //Room Allocation Requests Accepted
            $allocated_seat_id = $data3->id;
            $this->roomrequestaccept2($id, $allocated_seat_id);
            //Sending Email to User That Room Allocation is Accepted
            $EmailController = new EmailController();
            $EmailController->RoomAllocationEmail($student_id, $room->title, 1);

            return redirect('admin/roomallocation')->with('success', 'AllocatedSeats Data has been added Successfully!');
        } else {
            return redirect('admin/roomallocation')->with('danger', 'No Data Found');
        }
    }
    public function roomrequestaccept2(string $id, string $allocated_seat_id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '1';
        $data->allocated_seat_id = $allocated_seat_id;
        $data->save();
        return redirect('admin/roomallocation/roomrequests')->with('success', 'Accepted Successfully!');
    }
    //Room Allocation Requests
    public function roomrequestaccept(string $id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '1';
        $data->save();

        $student_id = $data->user_id;
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail($student_id, $room->title, 1);
        return redirect('admin/roomallocation/roomrequests')->with('success', 'Accepted Successfully!');
    }
    public function roomrequestban(string $id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $allocated_seat_id = $data->allocated_seat_id;
        $data->status = '2';
        $data->save();

        $student_id = $data->user_id;
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail($student_id, $room->title, 2);

        if ($allocated_seat_id) {
            //Room Allocation Seat Delete
            $this->destroy($allocated_seat_id);
            return redirect('admin/roomallocation/roomrequests')->with('danger', 'Banned Successfully and Room Allocation is Deleted!');
        } else {
            return redirect('admin/roomallocation/roomrequests')->with('danger', 'Banned Successfully!');
        }
    }
    public function roomrequestlist(string $id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '0';
        $data->save();

        $student_id = $data->user_id;
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail($student_id, $room->title, 3);
        return redirect()->route('admin.roomallocation.roomrequests')->with('warning', 'Listed for Queue Successfully!');
    }
}
