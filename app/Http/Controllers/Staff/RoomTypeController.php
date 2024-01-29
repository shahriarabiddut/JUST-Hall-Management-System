<?php

namespace App\Http\Controllers\Staff;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\RoomTypeImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RoomTypeController extends Controller
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
        $data = RoomType::all();
        return view('staff.roomType.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('staff.roomType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'details' => 'required',
            'price' => 'required',
        ]);
        $data = new RoomType;
        $data->title = $request->title;
        $data->price = $request->price;
        $data->details = $request->details;
        $data->save();
        if ($request->imgs) {
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('RoomTypeImages', 'public');
                $imgData = new RoomTypeImage;
                $imgData->room_type_id = $data->id;
                $imgData->img_src = 'app/public/' . $imgPath;
                $imgData->img_alt = $request->title;
                $imgData->save();
            }
        }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'add', 'Room Type ' . $data->title . ' has been Added Successfully!');
        //Saved
        return redirect()->route('staff.roomtype.index')->with('success', 'Room Type has been Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = RoomType::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomtype.index')->with('danger', 'Not Found!');
        }
        return view('staff.roomType.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = RoomType::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomtype.index')->with('danger', 'Not Found!');
        }
        return view('staff.roomType.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $data = RoomType::find($id);
        $formFields = $request->validate([
            'title' => 'required',
            'details' => 'required',
            'price' => 'required',
        ]);
        $data->update($formFields);
        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('RoomTypeImages', 'public');
                $imgData = new RoomTypeImage;
                $imgData->room_type_id = $data->id;
                $imgData->img_src = 'app/public/' . $imgPath;
                $imgData->img_alt = $request->title;
                $imgData->save();
            }
        }
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'update', 'Room Type ' . $data->title . ' has been updated Successfully!');
        //Saved
        return redirect()->route('staff.roomtype.index')->with('success', 'Data has been updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = RoomType::find($id);
        if ($data == null) {
            return redirect()->route('staff.roomtype.index')->with('danger', 'Not Found!');
        }
        //Delete It's Images
        foreach ($data->roomtypeimages as $img) {
            $dataDelete = RoomTypeImage::find($img->id);
            $path = 'storage/' . $dataDelete->img_src;
            if (File::exists($path)) {
                File::delete($path);
            }
            //Delete Image
            $dataDelete->delete();
        }
        $data->delete();
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'delete', 'Room Type ' . $data->title . ' has been deleted Successfully!');
        //Saved
        return redirect()->route('staff.roomtype.index')->with('danger', 'Data has been deleted Successfully!');
    }
    public function destroy_image($id)
    {
        $data = RoomTypeImage::find($id);
        $room_type_id = $data->room_type_id;
        //Delete Image from storage
        $path = 'storage/' . $data->img_src;
        if (File::exists($path)) {
            File::delete($path);
        }
        //Delete Image
        $data->delete();
        $data2 = RoomType::find($room_type_id);
        //Saving History 
        $HistoryController = new HistoryController();
        $staff_id = Auth::guard('staff')->user()->id;
        $HistoryController->addHistory($staff_id, 'delete', 'Room Type ' . $data2->title . ' , A Photo was deleted Successfully!');
        //Saved
        return response()->json(['bool' => true]);
    }
}
