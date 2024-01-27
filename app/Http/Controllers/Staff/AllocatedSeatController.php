<?php

namespace App\Http\Controllers\Staff;

use App\Models\Room;
use App\Models\Student;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AllocatedSeatController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('staff')->user()->type == 'provost') {
                return $next($request);
                // return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            } elseif (Auth::guard('staff')->user()->type == 'aprovost') {
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
        $data = AllocatedSeats::all();
        return view('staff.roomallocation.index', ['data' => $data]);
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
        return view('staff.roomallocation.create', ['students' => $students, 'rooms' => $rooms]);
    }

    //Get Positions
    public function getPositions($selectedValue)
    {
        // Your logic to fetch data based on $selectedValue
        $data = Room::find($selectedValue);

        return response()->json($data->positions);
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
        //
        $data->save();
        // Room Vacancy - 1
        $roomid = $request->room_id;
        $room = Room::find($roomid);
        $roomVacant = $room->vacancy - 1;
        $room->vacancy = $roomVacant;
        // Room Vancacy deleted
        // Remove a specific position from the Room Positions
        $arrayRepresentation = json_decode($room->positions, true);
        $filteredArray = array_diff($arrayRepresentation, array($request->position));
        $filteredArray = array_values($filteredArray);
        $jsonData = json_encode($filteredArray);
        $room->positions = $jsonData;
        // Removed
        $room->save();
        // 

        return redirect('staff/roomallocation')->with('success', 'AllocatedSeats Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        return view('staff.roomallocation.show', ['data' => $data]);
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
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        return view('staff.roomallocation.edit', ['data' => $data, 'students' => $students, 'rooms' => $rooms]);
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
            'position' => 'required',
        ]);
        $data->room_id = $request->room_id;
        $data->position = $request->position;
        //
        // room change
        if ($request->room_id != $request->old_room_id) {
            // Room Vacancy - 1 for new room
            $roomid = $request->room_id;
            $room = Room::find($roomid);
            $roomVacant = $room->vacancy - 1;
            $room->vacancy = $roomVacant;
            // Room Vancacy deleted
            // Remove a specific position from the Room Positions for new room
            $arrayRepresentation = json_decode($room->positions, true);
            $filteredArray = array_diff($arrayRepresentation, array($request->position));
            $filteredArray = array_values($filteredArray);
            $jsonData = json_encode($filteredArray);
            $room->positions = $jsonData;
            //
            $room->save();
            // Room Vacancy + 1 for old room
            $roomoldid = $request->old_room_id;
            $roomold = Room::find($roomoldid);
            $roomVacant = $roomold->vacancy + 1;
            $roomold->vacancy = $roomVacant;
            //Room Vancacy Readded
            // Add The position back to Room Positions for old room
            $arrayRepresentation = json_decode($roomold->positions, true);
            array_push($arrayRepresentation, (int)$request->old_position);
            sort($arrayRepresentation);
            $jsonData = json_encode($arrayRepresentation);
            $roomold->positions = $jsonData;

            //
            $roomold->save();
        }
        //Same Room Postion change
        if ($request->room_id == $request->old_room_id) {
            // Remove a specific position from the Room Positions for old room
            $roomid = $request->room_id;
            $room = Room::find($roomid);
            $arrayRepresentation = json_decode($room->positions, true);
            $filteredArray = array_diff($arrayRepresentation, array($request->position));
            $filteredArray = array_values($filteredArray);
            $jsonData = json_encode($filteredArray);
            // Add The position back to Room Positions for old room
            $arrayRepresentation = json_decode($jsonData, true);
            array_push($arrayRepresentation, (int)$request->old_position);
            sort($arrayRepresentation);
            $jsonData = json_encode($arrayRepresentation);
            $room->positions = $jsonData;

            //
            $room->save();
        }
        //
        $data->save();

        return redirect('staff/roomallocation')->with('success', 'AllocatedSeats Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        // Room Vacancy + 1
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        $roomVacant = $room->vacancy + 1;
        $room->vacancy = $roomVacant;
        //Room Vancacy Readded
        // Add The position back to Room Positions
        $arrayRepresentation = json_decode($room->positions, true);
        array_push($arrayRepresentation, $data->position);
        sort($arrayRepresentation);
        $jsonData = json_encode($arrayRepresentation);
        $room->positions = $jsonData;
        //
        $room->save();
        //
        $data->delete();
        return redirect('staff/roomallocation')->with('danger', 'Data has been deleted Successfully!');
    }
    //Room Allocation Requests
    public function roomrequests()
    {
        $data = RoomRequest::orderBy('created_at', 'desc')->get();
        return view('staff.roomallocation.requests', ['data' => $data]);
    }
    //Room Allocation Requests Details
    public function showRoomRequest(string $id)
    {
        //
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        $student_id = $data->user_id;
        $data2 = Student::find($student_id);
        if ($data) {
            $data->flag = 1;
            $data->save();
            return view('staff.roomallocation.roomrequestshow', ['data' => $data, 'data2' => $data2]);
        } else {
            return redirect('staff/roomallocation')->with('danger', 'No Data Found');
        }
    }
    //Room Allocation Requests Details
    public function RoomRequestAllocate(string $id)
    {
        //
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
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

            return redirect('staff/roomallocation')->with('success', 'AllocatedSeats Data has been added Successfully!');
        } else {
            return redirect('staff/roomallocation')->with('danger', 'No Data Found');
        }
    }
    public function roomrequestaccept2(string $id, string $allocated_seat_id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '1';
        $data->allocated_seat_id = $allocated_seat_id;
        $data->save();
        return redirect('staff/roomallocation/roomrequests')->with('success', 'Accepted Successfully!');
    }
    //Room Allocation Requests
    public function roomrequestaccept(string $id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '1';
        $data->save();

        $student_id = $data->user_id;
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail($student_id, $room->title, 1);
        return redirect('staff/roomallocation/roomrequests')->with('success', 'Accepted Successfully!');
    }
    public function roomrequestban(string $id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
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
            return redirect('staff/roomallocation/roomrequests')->with('danger', 'Banned Successfully and Room Allocation is Deleted!');
        } else {
            return redirect('staff/roomallocation/roomrequests')->with('danger', 'Banned Successfully!');
        }
    }
    public function roomrequestlist(string $id)
    {
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '0';
        $data->save();

        $student_id = $data->user_id;
        $roomid = $data->room_id;
        $room = Room::find($roomid);
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail($student_id, $room->title, 3);
        return redirect()->route('staff.roomallocation.roomrequests')->with('warning', 'Listed for Queue Successfully!');
    }
}
