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
        if ($request->imgs) {
            foreach ($request->file('imgs') as $img) {
                $imgPath = $img->store('RoomTypeImages', 'public');
                $imgData = new RoomTypeImage;
                $imgData->room_type_id = $data->id;
                $imgData->img_src = $imgPath;
                $imgData->img_alt = $request->title;
                $imgData->save();
            }
        }

        $data->save();
        return redirect('staff/roomtype')->with('success', 'Room Type has been Created Successfully!');
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
                $imgData->img_src = $imgPath;
                $imgData->img_alt = $request->title;
                $imgData->save();
            }
        }
        return redirect('staff/roomtype')->with('success', 'Data has been updated Successfully!');
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
        return redirect('staff/roomtype')->with('danger', 'Data has been deleted Successfully!');
    }
    public function destroy_image($id)
    {
        $data = RoomTypeImage::find($id);
        //Delete Image from storage
        $path = 'storage/' . $data->img_src;
        if (File::exists($path)) {
            File::delete($path);
        }
        //Delete Image
        $data->delete();
        return response()->json(['bool' => true]);
    }
}
