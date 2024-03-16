<?php

namespace App\Http\Controllers\Staff;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Balance;
use App\Models\Payment;
use App\Models\Student;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use App\Models\AllocatedSeats;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AllocatedSeatController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::guard('staff')->user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null || Auth::guard('staff')->user()->status == 0) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            }
            if (Auth::guard('staff')->user()->hall->status == 0) {
                return redirect()->route('staff.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
            }
            if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'aprovost') {
                return $next($request);
                // return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
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
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = AllocatedSeats::all()->where('hall_id', $this->hall_id);
        return view('staff.roomallocation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //Student Data segregation
        $unstudents = DB::select("SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM allocated_seats) OR hall_id = 0 AND hall_id = $this->hall_id");
        $data = [];
        foreach ($unstudents as $student) {
            if ($student->status == 1 && $student->gender == Auth::guard('staff')->user()->hall->type) {
                if ($student->hall_id == $this->hall_id || $student->hall_id == 0 || $student->hall_id == null) {
                    $data[] = $student;
                }
            }
        }
        $students = $data;
        //Room Data segregation
        $rooms = Room::all()->where('vacancy', '!=', 0)->where('hall_id', $this->hall_id);
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
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = new AllocatedSeats;
        $request->validate([
            'room_id' => 'required|not_in:0',
            'user_id' => 'required|not_in:0',
            'position' => 'required',
        ]);
        $data->room_id = $request->room_id;
        $data->user_id = $request->user_id;
        $data->position = $request->position;
        $data->hall_id = $this->hall_id;
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'allocation', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room is Allocated Successfully!', $this->hall_id);
        //Saved
        // User Data Update
        $studentData = Student::find($data->user_id);
        $studentData->hall_id = $this->hall_id;
        $studentData->save();
        //Connect Balance Account
        $dataBalance = Balance::all()->where('student_id', $data->user_id)->first();
        $dataBalance->hall_id = $this->hall_id;
        $dataBalance->save();

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
        return redirect()->route('staff.roomallocation.index')->with('success', 'Room Allocation Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.roomallocation.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $students = Student::all()->where('hall_id', $this->hall_id);
        $rooms = Room::all()->where('hall_id', $this->hall_id)->where('vacancy', '!=', 0);
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
        }
        if ($data->students->status != 1) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'User is Disabled/Removed!');
        }
        return view('staff.roomallocation.edit', ['data' => $data, 'students' => $students, 'rooms' => $rooms]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = AllocatedSeats::find($id);

        $request->validate([
            'room_id' => 'required|not_in:0',
            'position' => 'required',
        ]);
        $data->room_id = $request->room_id;
        $data->position = $request->position;
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
        }
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
            if ($data->status == 1) {

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

            if ($data->status == 0) {
                $roomVacant = $room->vacancy - 1;
                $room->vacancy = $roomVacant;
            } elseif ($request->old_position != $request->position) {
                // Add The position back to Room Positions for old room
                $arrayRepresentation = json_decode($jsonData, true);
                array_push($arrayRepresentation, (int)$request->old_position);
                sort($arrayRepresentation);
                $jsonData = json_encode($arrayRepresentation);
            }
            $room->positions = $jsonData;
            //
            $room->save();
        }
        //
        if ($data->status == 0) {
            // User Data Update
            $studentData = Student::find($data->user_id);
            $studentData->hall_id = $this->hall_id;
            $studentData->save();
            //Connect Balance Account
            $dataBalance = Balance::all()->where('student_id', $studentData->id)->first();
            $dataBalance->hall_id = $this->hall_id;
            $dataBalance->save();
            //
            $data->status = 1;
        }
        // Add The report to report array
        $arrayReport = json_decode($data->report, true);
        array_push($arrayReport, 'Room Allocation Updated - Room No ' . $room->title . ' and Seat No ' . $request->position . ' on ' . $room->updated_at->format('F j,Y'));
        sort($arrayReport);
        $jsonData = json_encode($arrayReport);
        $data->report = $jsonData;
        //
        $data->save();
        //


        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'allocation update', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room is Allocation Updated Successfully!', $this->hall_id);
        //Saved
        return redirect('staff/roomallocation')->with('success', 'AllocatedSeats Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
        }
        if ($data->status != 1) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.roomallocation.cancel', ['data' => $data]);
    }
    public function delete(Request $request)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $request->validate([
            'objective' => 'required|not_in:0',
            'report' => 'required',
            'id' => 'required',
        ]);
        $id = $request->id;
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
        }
        if ($data->status != 1) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
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
        //Room Request Clean
        $data2 = RoomRequest::all()->where('user_id', $data->user_id)->first();
        if ($data2 != null) {
            $data2->allocated_seat_id = 0;
            $data2->status = 2;
            $data2->save();
        }
        //
        $data->status = 0;
        $data->objective = $request->objective;
        // Add The report to report array
        if ($request->objective == 1) {
            $report = 'Room and Seat Canceled - Room No ' . $room->title . ' and Seat No ' . $data->position . ' has been cleared on ' . $room->updated_at->format('F j,Y') . '. Additional report - ' . $request->report;
        } elseif ($request->objective == 2) {
            $report = 'Rusticated on ' . $room->updated_at->format('F j,Y') . ' . Report or Reason - ' . $request->report;
        }
        $arrayReport = json_decode($data->report, true);
        if ($data->report == null) {
            $data->report = [];
        }
        array_push($arrayReport, $report);
        sort($arrayReport);
        $jsonData = json_encode($arrayReport);
        $data->report = $jsonData;
        //
        $data->save();
        // $data->delete();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'delete', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room Allocation has been removed successfully!', $this->hall_id);
        //Saved
        return redirect('staff/roomallocation')->with('danger', 'Room Allocation has been removed successfully!');
    }
    // public function destroyAll()
    // {

    //     $dataAll = AllocatedSeats::all()->where('hall_id', $this->hall_id);
    //     if ($dataAll == null) {
    //         return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
    //     }
    //     foreach($dataAll as $data){
    //     // User Data Update
    //     $studentData = Student::find($data->user_id);
    //     $studentData->hall_id = 0;
    //     $studentData->save();
    //     //Connect Balance Account
    //     $dataBalance = Balance::all()->where('student_id', $studentData->id)->first();
    //     $dataBalance->hall_id = 0;
    //     $dataBalance->save();
    //     // Room Vacancy + 1
    //     $roomid = $data->room_id;
    //     $room = Room::find($roomid);
    //     $roomVacant = $room->vacancy + 1;
    //     $room->vacancy = $roomVacant;
    //     //Room Vancacy Readded
    //     // Add The position back to Room Positions
    //     $arrayRepresentation = json_decode($room->positions, true);
    //     array_push($arrayRepresentation, $data->position);
    //     sort($arrayRepresentation);
    //     $jsonData = json_encode($arrayRepresentation);
    //     $room->positions = $jsonData;
    //     //
    //     $room->save();
    //     //Room Request Clean
    //     $data2 = RoomRequest::all()->where('user_id', $data->user_id)->first();
    //     if ($data2 != null) {
    //         $data2->allocated_seat_id = 0;
    //         $data2->status = 2;
    //         $data2->save();
    //     }
    //     //
    //     $data->delete();
    //     // //Saving History 
    //     // $HistoryController = new HistoryController();
    //     // $staff_id = Auth::guard('staff')->user()->id;
    //     // $HistoryController->addHistoryHall($staff_id, 'delete', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room Allocation has been deleted Successfully!', $this->hall_id);
    //     // //Saved
    //     }
    //     return redirect('staff/roomallocation')->with('danger', 'Data has been deleted Successfully!');
    // }
    //Room Allocation Requests
    public function roomrequests()
    {
        $data = RoomRequest::orderBy('created_at', 'desc')->where('hall_id', $this->hall_id)->get();
        return view('staff.roomallocation.requests', ['data' => $data]);
    }
    //Room Allocation Requests Details
    public function showRoomRequest(string $id)
    {
        //
        $data = RoomRequest::find($id);
        $rooms = Room::all()->where('vacancy', '!=', 0)->where('hall_id', $data->hall_id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        //
        if ($data->visited_at != null) {
            $currentTime = Carbon::now();
            $maxVisitTime = $data->visited_at;
            $diff = $currentTime->diff($maxVisitTime);
            if ($maxVisitTime >= $currentTime && $data->visitor != Auth::guard('staff')->user()->id) {
                return redirect()->back()->with('danger', 'You can view after ' . $diff->format('%i minutes %s seconds') . ' . ' . $data->visit->name . ' is currently reading the application.');
            }
        }
        //
        $application = json_decode($data->application, true);
        $student_id = $data->user_id;
        $dataAllocation = AllocatedSeats::all()->where('user_id', $student_id)->first();
        $dataPayment = Payment::all()->where('type', 'roomrequest')->where('student_id', $student_id)->where('service_id', $data->id)->first();
        if ($data) {
            $data->flag = 1;
            $data->visited_at = Carbon::now()->addMinutes(10);
            $data->visitor = Auth::guard('staff')->user()->id;
            $data->save();
            return view('staff.roomallocation.roomrequestshow', ['data' => $data, 'application' => $application, 'rooms' => $rooms, 'dataPayment' => $dataPayment, 'dataAllocation' => $dataAllocation]);
        } else {
            return redirect('staff/roomallocation')->with('danger', 'No Data Found');
        }
    }
    //Room Allocation Requests Details
    public function RoomRequestAllocate(Request $request)
    {
        $request->validate([
            'room_id' => 'required|not_in:0',
            'position' => 'required',
            'id' => 'required|not_in:0',
        ]);
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        //
        $data = RoomRequest::find($request->id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Found!');
        }
        if ($data->status != 1) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        $dataAllocation = AllocatedSeats::all()->where('user_id', $data->user_id)->first();
        if ($dataAllocation != null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', ' Warning ! Room Allocation Found for this User!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        $student_id = $data->user_id;
        $room_id = $request->room_id;
        //
        $data2 = Student::find($student_id);
        $data2->hall_id = $this->hall_id;
        $data2->save();
        //Connect Balance Account
        $dataBalance = Balance::all()->where('student_id', $data2->id)->first();
        $dataBalance->hall_id = $this->hall_id;
        $dataBalance->save();
        //
        $room = Room::find($room_id);
        if ($room->vacancy == 0) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Room is Full!');
        }
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
        // Room Vancacy deleted
        if ($data) {
            //Allocating seat 
            $data3 = new AllocatedSeats();
            $data3->room_id = $room_id;
            $data3->user_id = $student_id;
            $data3->position = $request->position;
            $data3->hall_id =  $this->hall_id;
            $data3->status =  1;
            // Add The report to report array
            $data3->report = "[]";
            $arrayReport = json_decode($data3->report, true);
            array_push($arrayReport, 'Room Allocated - Room No ' . $room->title . ' and Seat No ' . $request->position . ' on ' . $room->updated_at->format('F j,Y'));
            sort($arrayReport);
            $jsonData = json_encode($arrayReport);
            $data3->report = $jsonData;
            //
            $data3->save();

            //Room Allocation Requests Accepted
            $allocated_seat_id = $data3->id;
            $this->roomrequestaccept2($request->id, $allocated_seat_id, $room_id);
            //Sending Email to User That Room Allocation is Accepted
            $EmailController = new EmailController();
            $EmailController->RoomAllocationEmail($student_id, $room->title, 1);

            //Saving History 
            $HistoryController = new HistoryController();
            $staff_id = Auth::guard('staff')->user()->id;
            $HistoryController->addHistoryHall($staff_id, 'accept', 'Student (' . $data2->rollno . ' ) - ' . $data2->name . ' , Room Allocation Request has been accepted and Room is Allocated Successfully!', $this->hall_id);
            //Saved
            return redirect('staff/roomallocation')->with('success', 'AllocatedSeats Data has been added Successfully!');
        } else {
            return redirect('staff/roomallocation')->with('danger', 'No Data Found');
        }
    }
    public function roomrequestaccept2(string $id, string $allocated_seat_id, string $room_id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        // Less than 10 minutes ago, redirect back
        if ($data->visited_at != null) {
            $currentTime = Carbon::now();
            $maxVisitTime = $data->visited_at;
            $diff = $currentTime->diff($maxVisitTime);
            if ($maxVisitTime >= $currentTime && $data->visitor != Auth::guard('staff')->user()->id) {
                return redirect()->back()->with('danger', 'You can perform any action again after ' . $diff->format('%i minutes %s seconds') . ' . ' . $data->visit->name . ' is currently reading the application.');
            }
        }
        //
        $data->status = '4';
        $data->room_id = $room_id;
        $data->allocated_seat_id = $allocated_seat_id;
        $data->save();
        return redirect('staff/roomallocation/roomrequests')->with('success', 'Accepted Successfully!');
    }
    //Room Allocation Requests
    public function roomrequestaccept(string $id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        // Less than 10 minutes ago, redirect back
        if ($data->visited_at != null) {
            $currentTime = Carbon::now();
            $maxVisitTime = $data->visited_at;
            $diff = $currentTime->diff($maxVisitTime);
            if ($maxVisitTime >= $currentTime && $data->visitor != Auth::guard('staff')->user()->id) {
                return redirect()->back()->with('danger', 'You can perform any action again after ' . $diff->format('%i minutes %s seconds') . ' . ' . $data->visit->name . ' is currently reading the application.');
            }
        }
        //
        $dataAllocation = AllocatedSeats::all()->where('user_id', $data->user_id)->first();
        if ($dataAllocation != null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', ' Warning ! Room Allocation Found for this User!');
        }
        $data->status = '1';
        $data->save();
        $student_id = $data->user_id;
        // Set Hall to that student
        $data2 = Student::find($student_id);
        $data2->hall_id = $data->hall_id;
        $data2->save();
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail2($student_id, 1);
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'accept', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room Allocation Request has been accepted Successfully!', $this->hall_id);
        //Saved
        return redirect('staff/roomallocation/roomrequests')->with('success', 'Accepted Successfully!');
    }
    public function roomrequestban(string $id)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        // Less than 10 minutes ago, redirect back
        if ($data->visited_at != null) {
            $currentTime = Carbon::now();
            $maxVisitTime = $data->visited_at;
            $diff = $currentTime->diff($maxVisitTime);
            if ($maxVisitTime >= $currentTime && $data->visitor != Auth::guard('staff')->user()->id) {
                return redirect()->back()->with('danger', 'You can perform any action again after ' . $diff->format('%i minutes %s seconds') . ' . ' . $data->visit->name . ' is currently reading the application.');
            }
        }
        //
        $dataAllocation = AllocatedSeats::all()->where('user_id', $data->user_id)->first();
        if ($dataAllocation != null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', ' Warning ! Room Allocation Found for this User!');
        }
        $allocated_seat_id = $data->allocated_seat_id;
        $data->status = '2';
        $data->save();

        $student_id = $data->user_id;
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail2($student_id, 2);
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'reject', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room Allocation Request has been rejected Successfully!', $this->hall_id);
        //Saved
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
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        // Less than 10 minutes ago, redirect back
        if ($data->visited_at != null) {
            $currentTime = Carbon::now();
            $maxVisitTime = $data->visited_at;
            $diff = $currentTime->diff($maxVisitTime);
            if ($maxVisitTime >= $currentTime && $data->visitor != Auth::guard('staff')->user()->id) {
                return redirect()->back()->with('danger', 'You can perform any action again after ' . $diff->format('%i minutes %s seconds') . ' . ' . $data->visit->name . ' is currently reading the application.');
            }
        }
        //
        $dataAllocation = AllocatedSeats::all()->where('user_id', $data->user_id)->first();
        if ($dataAllocation != null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', ' Warning ! Room Allocation Found for this User!');
        }
        $data->status = '0';
        $data->save();

        $student_id = $data->user_id;
        //Sending Email to User That Room Allocation is Accepted
        $EmailController = new EmailController();
        $EmailController->RoomAllocationEmail2($student_id, 3);
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'listed', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room Allocation Request has been listed for queue Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.roomallocation.roomrequests')->with('warning', 'Listed for Queue Successfully!');
    }
    // Import Bulk users and room allocation from csv
    public function importAllocation()
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        return view('staff.roomallocation.importAllocation');
    }

    public function handleImportAllocation(Request $request)
    {
        if (Auth::guard('staff')->user()->type == 'officer' || Auth::guard('staff')->user()->type == 'staff') {
            return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
        }
        $validator = $request->validate([
            'file' => 'required',
        ]);
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);
        $length = count($rows);
        $importedStudents = 0;
        $errorTitles = [];
        $xyz = 1;
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);

                $room_title = str_replace(' ', '', $row['roomtitle']);
                $rollno = str_replace(' ', '', $row['rollno']);
                $position = $row['position'];

                //User Data
                $user = User::all()->where('rollno', $rollno)->first();

                // Room Vacancy - 1
                $room = Room::all()->where('title', $room_title)->where('hall_id', $this->hall_id)->first();
                if ($room == null) {
                    $errorTitles[] = 'Room No ' . $room_title . '! No Such Room Found';
                    $xyz = 0;
                } elseif ($room->vacancy == 0) {
                    $errorTitles[] = ' No Vacancy found on Room no ' . $room_title . ' , ';
                    $xyz = 0;
                }
                if ($xyz != 0) {
                    $roomVacant = $room->vacancy - 1;
                    $room->vacancy = $roomVacant;
                    // Room Vancacy deleted
                    if ($position) {
                        // Remove a specific position from the Room Positions
                        $arrayRepresentation = json_decode($room->positions, true);
                        $filteredArray = array_diff($arrayRepresentation, array($position));
                        $filteredArray = array_values($filteredArray);
                        $jsonData = json_encode($filteredArray);
                        $room->positions = $jsonData;
                        // Removed
                    } else {
                        $aposition = 0;
                        // Remove a position from the Room Positions
                        $arrayRepresentation = json_decode($room->positions, true);
                        foreach ($arrayRepresentation as $key => $data) {
                            if ($key == 0) {
                                $aposition = $data;
                            }
                        }
                        $filteredArray = array_diff($arrayRepresentation, array($aposition));
                        $filteredArray = array_values($filteredArray);
                        $jsonData = json_encode($filteredArray);
                        $room->positions = $jsonData;
                        $position = $aposition;
                        // Removed
                    }
                }
                if ($user == null) {
                    $errorTitles[] = $rollno . ' No User Found';
                    $xyz = 0;
                } else {
                    $data = AllocatedSeats::all()->where('user_id', $user->id)->first();
                }
                //
                if ($xyz != 0) {
                    if ($data == null) {
                        $AllocatedSeatsData =  new AllocatedSeats();
                        $AllocatedSeatsData->room_id = $room->id;
                        $AllocatedSeatsData->user_id = $user->id;
                        $AllocatedSeatsData->position = $position;
                        $AllocatedSeatsData->status = 1;
                        $AllocatedSeatsData->report = "[]";
                        $AllocatedSeatsData->hall_id = $this->hall_id;
                        $AllocatedSeatsData->save();
                        $room->save();
                        $importedStudents++;
                    } else {
                        if ($xyz != 0) {
                            $errorTitles[] = ' Room Allocation Found for this user roll no' . $user->rollno . '! ';
                        }
                    }
                }
            }
        }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        if ($importedStudents == 1) {
            $HistoryController->addHistoryHall($staff_id, 'import', ' Room Allocation has been failed !', $this->hall_id);
        } else {
            $HistoryController->addHistoryHall($staff_id, 'import', 'Today ' . $importedStudents . ' Room Allocation has been imported Successfully!', $this->hall_id);
        }
        //Saved
        if ($errorTitles == null) {
            return redirect()->route('staff.roomallocation.index')->with('success', 'Today ' . $importedStudents . ' Room Allocation has been imported Successfully!');
        } else {
            return redirect()->route('staff.roomallocation.index')->with('success', 'Today ' . $importedStudents . ' Room Allocation has been imported Successfully!')->with('danger-titles', $errorTitles);
        }
    }
    public function generatePDF(string $rollno)
    {
        $mpdf = new \Mpdf\Mpdf(([
            'default_font_size' => 12,
            'default_font' => 'nikosh'
        ]));
        $Student = Student::all()->where('rollno', $rollno)->first();
        if ($Student == null) {
            return redirect()->route('staff.dashboard')->with('danger', 'Not Found');
        }
        $data = RoomRequest::all()->where('user_id', $Student->id)->where('hall_id', $this->hall_id)->first();
        if ($data == null) {
            return redirect()->route('staff.dashboard')->with('danger', 'Not Found');
        }
        $datahtml = $data->toArray();
        $html = view('staff.roomallocation.rr', $datahtml)->render();
        $mpdf->WriteHTML($html);
        return $mpdf->output($rollno . ' - RoomRequest.pdf', 'D');
    }
}
