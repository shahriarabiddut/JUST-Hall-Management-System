<?php

namespace App\Http\Controllers\Staff;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
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
    //
    public function index()
    {
        $data = Room::all();
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
        $data = new Room;
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

        return redirect('staff/rooms')->with('success', 'Room Data has been added Successfully!');
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
        return view('staff.room.edit', ['data' => $data, 'roomtypes' => $roomtypes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = Room::find($id);
        $data->room_type_id = $request->rt_id;
        $data->title = $request->title;
        $data->totalseats = $request->totalseats;
        $data->save();

        return redirect('staff/rooms')->with('success', 'Room Data has been updated Successfully!');
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
        $data->delete();
        return redirect('staff/rooms')->with('danger', 'Data has been deleted Successfully!');
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
        $errorTitles = [];
        foreach ($rows as $key => $row) {
            if ($key != $length - 1) {
                $row = array_combine($header, $row);
                $title = $row['title'];
                $room_type_id = $row['room_type_id'];
                //
                $positions = [];
                for ($i = 1; $i <= $room_type_id; $i++) {
                    $positions[] = $i;
                }
                $jsonData = json_encode($positions);
                $positions = $jsonData;
                //
                $data = Room::where('title', $title)->first();
                if ($data == null) {
                    $RoomData =  Room::create([
                        'title' => $row['title'],
                        'room_type_id' => $row['room_type_id'],
                        'totalseats' => $row['totalseats'],
                        'vacancy' => $row['totalseats'],
                        'positions' => $positions
                    ]);
                } else {
                    $errorTitles[] = $title;
                }
            }
        }
        if ($errorTitles == null) {
            return redirect()->route('staff.rooms.index')->with('success', 'Room Data has been imported Successfully!');
        } else {
            return redirect()->route('staff.rooms.index')->with('success', 'Room Data has been imported Successfully!')->with('danger-titles', $errorTitles);
        }
    }
}
