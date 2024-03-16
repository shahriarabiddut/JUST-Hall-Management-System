<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hall;
use App\Models\Room;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Student;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class AllocatedSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AllocatedSeats::all();
        $hall = Hall::all();
        return view('admin.roomallocation.index', ['data' => $data, 'hall' => $hall]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.roomallocation.index');
        // //Student Data segregation
        // $unstudents = DB::select("SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM allocated_seats)");
        // $data = [];
        // foreach ($unstudents as $student) {
        //     $data[] = $student;
        // }
        // $students = $data;
        // //Room Data segregation
        // $rooms = Room::all()->where('vacancy', '!=', 0);
        // $hall = Hall::all()->where('status', '!=', 0);
        // return view('admin.roomallocation.create', ['students' => $students, 'rooms' => $rooms, 'hall' => $hall]);
    }
    public function create1(string $hall_id)
    {
        //Student Data segregation
        $unstudents = DB::select("SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM allocated_seats) OR hall_id = 0 AND hall_id = $hall_id");
        $halls = Hall::find($hall_id);
        $data = [];
        foreach ($unstudents as $student) {
            if ($student->status == 1 && $student->gender == $halls->type) {
                if ($student->hall_id == $hall_id || $student->hall_id == 0 || $student->hall_id == null) {
                    $data[] = $student;
                }
            }
        }
        $students = $data;
        //Room Data segregation
        $rooms = Room::all()->where('vacancy', '!=', 0)->where('hall_id', $hall_id);
        return view('admin.roomallocation.create', ['students' => $students, 'rooms' => $rooms, 'hall_id' => $hall_id]);
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
            'room_id' => 'required|not_in:0',
            'user_id' => 'required|not_in:0',
            'position' => 'required',
            'hall_id' => 'required',
        ]);
        $data->room_id = $request->room_id;
        $data->user_id = $request->user_id;
        $data->position = $request->position;
        $data->hall_id = $request->hall_id;
        $data->status = 1;
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
        // User Data Update
        $studentData = Student::find($data->user_id);
        $studentData->hall_id = $data->hall_id;
        $studentData->save();
        //Connect Balance Account
        $dataBalance = Balance::all()->where('student_id', $data->user_id)->first();
        $dataBalance->hall_id = $data->hall_id;
        $dataBalance->save();
        //
        // Add The report to report array
        $data->report = "[]";
        $arrayReport = json_decode($data->report, true);
        array_push($arrayReport, 'Room Allocated - Room No ' . $room->title . ' and Seat No ' . $request->position . ' on ' . $room->updated_at->format('F j,Y'));
        sort($arrayReport);
        $jsonData = json_encode($arrayReport);
        $data->report = $jsonData;
        //
        $data->save();
        //
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
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        $students = Student::all()->where('hall_id', $data->hall_id);
        $rooms = Room::all()->where('hall_id', $data->hall_id);
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
            'room_id' => 'required|not_in:0',
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
        // Add The report to report array
        $arrayReport = json_decode($data->report, true);
        array_push($arrayReport, 'Room Allocation Updated - Room No ' . $room->title . ' and Seat No ' . $request->position . ' on ' . $room->updated_at->format('F j,Y'));
        sort($arrayReport);
        $jsonData = json_encode($arrayReport);
        $data->report = $jsonData;
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
            return redirect()->route('admin.roomallocation.index')->with('danger', 'Not Found!');
        }
        // User Data Update
        $studentData = Student::find($data->user_id);
        $studentData->hall_id = 0;
        $studentData->save();
        //Connect Balance Account
        $dataBalance = Balance::all()->where('student_id', $studentData->id)->first();
        $dataBalance->hall_id = 0;
        $dataBalance->save();
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
        //Room Request Clean
        $data2 = RoomRequest::all()->where('user_id', $data->user_id)->first();
        if ($data2 != null) {
            $data2->allocated_seat_id = 0;
            $data2->status = 2;
            $data2->save();
        }
        //
        $data->status = 0;
        $data->objective = 1;
        // Add The report to report array
        $report = 'Room and Seat Canceled - Room No ' . $room->title . ' and Seat No ' . $data->position . ' has been cleared on ' . $room->updated_at->format('F j,Y') . ' by System Admin.';
        $arrayReport = json_decode($data->report, true);
        array_push($arrayReport, $report);
        sort($arrayReport);
        $jsonData = json_encode($arrayReport);
        $data->report = $jsonData;
        //
        $data->save();
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
        if ($data != null) {
            $application = json_decode($data->application, true);
            $student_id = $data->user_id;
            $dataAllocation = AllocatedSeats::all()->where('user_id', $student_id)->first();
            $dataPayment = Payment::all()->where('type', 'roomrequest')->where('student_id', $student_id)->where('service_id', $data->id)->first();
            return view('admin.roomallocation.roomrequestshow', ['data' => $data, 'data2' => $data2, 'application' => $application, 'dataPayment' => $dataPayment, 'dataAllocation' => $dataAllocation]);
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
    public function generatePDF(string $rollno)
    {
        $mpdf = new \Mpdf\Mpdf(([
            'default_font_size' => 12,
            'default_font' => 'nikosh'
        ]));
        $Student = Student::all()->where('rollno', $rollno)->first();
        if ($Student == null) {
            return redirect()->route('admin.dashboard')->with('danger', 'Not Found');
        }
        $data = RoomRequest::all()->where('user_id', $Student->id)->first();
        if ($data == null) {
            return redirect()->route('admin.dashboard')->with('danger', 'Not Found');
        }
        $datahtml = $data->toArray();
        $html = view('admin.roomallocation.rr', $datahtml)->render();
        $mpdf->WriteHTML($html);
        return $mpdf->output($rollno . ' - RoomRequest.pdf', 'D');
    }
}
