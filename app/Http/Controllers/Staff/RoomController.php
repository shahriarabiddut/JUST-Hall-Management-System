<?php

namespace App\Http\Controllers\Staff;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    protected $hall_id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->hall_id = Auth::guard('staff')->user()->hall_id;
            if ($this->hall_id == 0 || $this->hall_id == null) {
                return redirect()->route('staff.dashboard')->with('danger', 'Unauthorized access');
            }
            if (Auth::guard('staff')->user()->hall->status == 0) {
                return redirect()->route('staff.dashboard')->with('danger', 'This Hall has been Disabled by System Administrator!');
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
    //
    public function index()
    {
        $data = Room::all()->where('hall_id', $this->hall_id);
        return view('staff.room.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roomtypes = RoomType::all();
        return view('staff.room.create', ['roomtypes' => $roomtypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'rt_id' => 'required',
            'totalseats' => 'required',
        ]);
        $data = new Room;
        $data->hall_id = $this->hall_id;
        $data->room_type_id = $request->rt_id;
        $data->title = $request->title;
        $data->totalseats = $request->totalseats;
        $data->vacancy = $request->totalseats;
        //
        $positions = [];
        for ($i = 1; $i <= $request->totalseats; $i++) {
            $positions[] = $i;
        }
        $jsonData = json_encode($positions);
        $data->positions = $jsonData;
        //
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'add', 'Room ' . $data->title . ' has been added Successfully!', $this->hall_id);
        //Saved

        return redirect()->route('staff.rooms.index')->with('success', 'Room has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Room::find($id);
        if ($data == null) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.room.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $roomtypes = RoomType::all();
        $data = Room::find($id);
        if ($data == null) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Permitted!');
        }
        return view('staff.room.edit', ['data' => $data, 'roomtypes' => $roomtypes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title' => 'required',
        ]);
        $data = Room::find($id);
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Permitted!');
        }
        $data->title = $request->title;
        $data->save();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'update', 'Room ' . $data->title . ' has been updated Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.rooms.index')->with('success', 'Room has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Room::find($id);
        if ($data == null) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Found!');
        }
        if ($data->hall_id != $this->hall_id) {
            return redirect()->route('staff.rooms.index')->with('danger', 'Not Permitted!');
        }
        $data->delete();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'delete', 'Room ' . $data->title . ' has been deleted Successfully!', $this->hall_id);
        //Saved
        return redirect()->route('staff.rooms.index')->with('danger', 'Room has been deleted Successfully!');
    }
    // Import Bilk users from csv
    public function importRoom()
    {
        return view('staff.room.importRoom');
    }

    public function handleImportRoom(Request $request)
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
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);
                $title = $row['title'];
                $room_type_id = $row['room_type_id'];
                //
                if ($room_type_id == 0) {
                    $roomType = 7;
                    $totalseats = 20;
                } else {
                    $roomType = $room_type_id;
                    $totalseats = $row['totalseats'];
                }
                //
                $positions = [];
                for ($i = 1; $i <= $totalseats; $i++) {
                    $positions[] = $i;
                }
                $jsonData = json_encode($positions);
                $positions = $jsonData;
                //
                $data = Room::where('title', $title)->first();

                $titleMain = str_replace(' ', '', $row['title']);
                if ($data == null) {

                    $RoomData =  Room::create([
                        'title' => $titleMain,
                        'room_type_id' => $roomType,
                        'totalseats' => $totalseats,
                        'vacancy' => $totalseats,
                        'positions' => $positions,
                        'hall_id' => $this->hall_id
                    ]);
                    $importedStudents++;
                } elseif ($data->totalseats < $totalseats && $data->hall_id == $this->hall_id) {
                    $data->positions = $positions;
                    $data->totalseats = $totalseats;
                    $data->vacancy = $totalseats;
                    $data->save();
                } else {
                    $errorTitles[] = $title;
                }
            }
        }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistoryHall($staff_id, 'add', 'Today ' . $importedStudents++ . ' Rooms has been imported Successfully!', $this->hall_id);
        //Saved
        if ($errorTitles == null) {
            return redirect()->route('staff.rooms.index')->with('success', 'Today ' . $importedStudents++ . ' Rooms has been imported Successfully!');
        } else {
            return redirect()->route('staff.rooms.index')->with('success', 'Today ' . $importedStudents++ . ' Rooms has been imported Successfully!')->with('danger-titles', $errorTitles);
        }
    }
}
