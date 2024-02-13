<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hall;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    //
    public function index()
    {
        $data = Room::all();
        return view('admin.room.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roomtypes = RoomType::all();
        $halls = Hall::all();
        return view('admin.room.create', ['roomtypes' => $roomtypes, 'halls' => $halls]);
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
            'hall_id' => 'required',
        ]);
        $data = new Room;
        $data->room_type_id = $request->rt_id;
        $data->title = $request->title;
        $data->totalseats = $request->totalseats;
        $data->vacancy = $request->totalseats;
        $data->hall_id = $request->hall_id;
        //
        $positions = [];
        for ($i = 1; $i <= $request->totalseats; $i++) {
            $positions[] = $i;
        }
        $jsonData = json_encode($positions);
        $data->positions = $jsonData;
        //
        $data->save();

        return redirect('admin/rooms')->with('success', 'Room Data has been added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Room::find($id);
        if ($data == null) {
            return redirect()->route('admin.rooms.index')->with('danger', 'Not Found!');
        }
        return view('admin.room.show', ['data' => $data]);
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
            return redirect()->route('admin.rooms.index')->with('danger', 'Not Found!');
        }
        return view('admin.room.edit', ['data' => $data, 'roomtypes' => $roomtypes]);
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
        $data->title = $request->title;
        $data->save();

        return redirect('admin/rooms')->with('success', 'Room Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Room::find($id);
        if ($data == null) {
            return redirect()->route('admin.rooms.index')->with('danger', 'Not Found!');
        }
        $data->delete();
        return redirect('admin/rooms')->with('danger', 'Data has been deleted Successfully!');
    }
    // Import Bilk users from csv
    public function importRoom()
    {
        return view('admin.room.importRoom');
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
                $hall_id = $row['hall_id'];
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
                        'hall_id' => $hall_id
                    ]);
                    $importedStudents++;
                } elseif ($data->totalseats < $totalseats) {
                    $data->positions = $positions;
                    $data->totalseats = $totalseats;
                    $data->vacancy = $totalseats;
                    $data->save();
                } else {
                    $errorTitles[] = $title;
                }
            }
        }
        if ($errorTitles == null) {
            return redirect()->route('admin.rooms.index')->with('success', 'Today ' . $importedStudents++ . ' Rooms has been imported Successfully!');
        } else {
            return redirect()->route('admin.rooms.index')->with('success', 'Today ' . $importedStudents++ . ' Rooms has been imported Successfully!')->with('danger-titles', $errorTitles);
        }
    }
}
