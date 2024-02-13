<?php

namespace App\Http\Controllers\Staff;

use App\Models\Room;
use App\Models\User;
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
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            }
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
        $data = AllocatedSeats::all()->where('hall_id', $this->hall_id);
        return view('staff.roomallocation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Student Data segregation
        $unstudents = DB::select("SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM allocated_seats) OR hall_id = 0 AND hall_id = $this->hall_id");
        $data = [];
        foreach ($unstudents as $student) {
            if ($student->hall_id == $this->hall_id || $student->hall_id == 0 || $student->hall_id == null) {
                $data[] = $student;
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
        $data->hall_id = $this->hall_id;
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
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'allocation', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room is Allocated Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.roomallocation.index')->with('success', 'Room Allocation Data has been added Successfully!');
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
        //
        $students = Student::all()->where('hall_id', $this->hall_id);
        $rooms = Room::all()->where('hall_id', $this->hall_id);
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
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
        $data = AllocatedSeats::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Permitted!');
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
        //Room Request Clean
        $data2 = RoomRequest::all()->where('user_id', $data->user_id)->where('room_id', $data->room_id)->first();
        if ($data2 != null) {
            $data2->allocated_seat_id = 0;
            $data2->status = 2;
            $data2->save();
        }
        //
        $data->delete();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'delete', 'Student (' . $data->students->rollno . ' ) - ' . $data->students->name . ' , Room Allocation has been deleted Successfully!', $this->hall_id);
        //Saved
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
        $application = json_decode($data->application, true);
        $rooms = Room::all()->where('vacancy', '!=', 0);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        $student_id = $data->user_id;
        $dataPayment = Payment::all()->where('type', 'roomrequest')->where('student_id', $student_id)->first();
        if ($data) {
            $data->flag = 1;
            $data->save();
            return view('staff.roomallocation.roomrequestshow', ['data' => $data, 'application' => $application, 'rooms' => $rooms, 'dataPayment' => $dataPayment]);
        } else {
            return redirect('staff/roomallocation')->with('danger', 'No Data Found');
        }
    }
    //Room Allocation Requests Details
    public function RoomRequestAllocate(Request $request)
    {
        //
        $data = RoomRequest::find($request->id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Found!');
        }
        if ($data->status != 1) {
            return redirect()->route('staff.roomallocation.roomrequests')->with('danger', 'Not Permitted!');
        }
        $student_id = $data->user_id;
        $room_id = $request->room_id;

        $data2 = Student::find($student_id);

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
            $data3 = new AllocatedSeats;
            $data3->room_id = $room_id;
            $data3->user_id = $student_id;

            $data3->position = $request->position;
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
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
        }
        $data->status = '4';
        $data->room_id = $room_id;
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
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
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
        $data = RoomRequest::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomallocation.index')->with('danger', 'Not Found!');
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
        return view('staff.roomallocation.importAllocation');
    }

    public function handleImportAllocation(Request $request)
    {
        $validator = $request->validate([
            'file' => 'required',
        ]);
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);
        $length = count($rows);
        $importedStudents = 1;
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
                $room = Room::all()->where('title', $room_title)->first();
                if ($room == null) {
                    $errorTitles[] = $room_title . ' No Such Room Found';
                    $xyz = 0;
                } elseif ($room->vacancy == 0) {
                    $errorTitles[] = $room_title . ' No Vacancy found on Room';
                    $xyz = 0;
                }
                if ($xyz != 0) {
                    $roomVacant = $room->vacancy - 1;
                    $room->vacancy = $roomVacant;
                    // Room Vancacy deleted
                    if ($room->room_type_id == 7) {
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
                    } else {
                        // Remove a specific position from the Room Positions
                        $arrayRepresentation = json_decode($room->positions, true);
                        $filteredArray = array_diff($arrayRepresentation, array($position));
                        $filteredArray = array_values($filteredArray);
                        $jsonData = json_encode($filteredArray);
                        $room->positions = $jsonData;
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
                        $AllocatedSeatsData =  AllocatedSeats::create([
                            'room_id' => $room->id,
                            'user_id' => $user->id,
                            'position' => $position,
                            'hall_id' => $this->hall_id
                        ]);
                        $room->save();
                        $importedStudents++;
                    } else {
                        if ($xyz != 0) {
                            $errorTitles[] = $user->rollno . ' Room Allocation Found for this user!';
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
}
