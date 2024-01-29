<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $data = History::latest()->get();
        return view('staff.history.index', ['data' => $data]);
    }
    public function show(string $id)
    {
        //
        $data = History::find($id);
        if ($data == null) {
            return redirect()->route('staff.history.index')->with('danger', 'Not Found!');
        }
        if ($data->status != 1) {
            $data->status = 1;
            $data->save();
        }
        return view('staff.history.show', ['data' => $data]);
    }
    public function read()
    {
        $data = History::all()->where('status', '0');
        foreach ($data as $d) {
            $data2 = History::find($d->id);
            $data2->status = 1;
            $data2->save();
        }
        return redirect()->route('staff.history.index')->with('success', 'Marked As Read!');
    }
    public function addHistory(string $staff_id, string $flag, string $data)
    {
        //
        $dataHistory = new History();
        $dataHistory->staff_id = $staff_id;
        $dataHistory->data = $data;
        $dataHistory->flag = $flag;
        $dataHistory->status = 0;
        $dataHistory->save();
    }
}
