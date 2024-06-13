<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Staff;
use App\Models\History;
use App\Models\Support;
use App\Models\RoomIssue;
use App\Models\HallOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard');
    }
    public function edit()
    {
        $datas = HallOption::all();
        return view('admin.settings.edit', ['datas' => $datas]);
    }
    public function update(Request $request, $id)
    {
        //

        $data = HallOption::find($id);
        $request->validate([
            'value' => 'required',
        ]);
        if ($id == 4 || $id == 5) {
            if ($request->hasFile('value')) {
                $data->value = 'storage/app/public/' . $request->file('value')->store('Website', 'public');
            }
        } else {
            $data->value = $request->value;
        }
        $data->save();
        if ($id == 1) {
            $data2 = HallOption::find(9);
            $data2->value = $request->value;
            $data2->save();
        }
        return redirect('admin/settings')->with('success', 'Settings has been updated Successfully!');
    }
    public function editPassword()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.layouts.changePassword', [
            'user' => $user,
        ]);
    }


    public function passwordUpdate(Request $request)
    {
        $formFields = $request->validate([
            'currentPassword' => 'required| min:6',
            'newPassword' => 'required| min:6',
            'confirmPassword' => 'required|same:newPassword',
            'userid' => 'required',
        ]);
        $data = Admin::find($request->userid);
        $oldPass = $data->password;
        $currentPassword = $request->currentPassword;
        if (Hash::check($currentPassword, $oldPass)) {
            //If user Given confirm poassword same
            $data->password = bcrypt(($request->newPassword));
            $data->save();
            return Redirect::route('admin.dashboard')->with('success', 'Password Updated Succesfully!');
        } else {
            return Redirect::back()->with('danger', "Current Password Didn't Match");
        }
    }
    //Admin Support
    public function supportIndex()
    {

        $data = Support::all();
        return view('admin.support.index', ['data' => $data]);
    }
    public function supportShow(string $id)
    {
        //
        $data = Support::find($id);
        return view('admin.support.show', ['data' => $data]);
    }
    //History
    public function historyIndex()
    {
        $data = History::latest()->get();
        return view('admin.history.index', ['data' => $data]);
    }
    public function historyShow(string $id)
    {
        //
        $data = History::find($id);
        if ($data == null) {
            return redirect()->route('staff.history.index')->with('danger', 'Not Found!');
        }
        // if ($data->status != 1) {
        //     $data->status = 1;
        //     $data->save();
        // }
        return view('admin.history.show', ['data' => $data]);
    }
    public function historyRead()
    {
        $data = History::all()->where('status', '0');
        foreach ($data as $d) {
            $data2 = History::find($d->id);
            $data2->status = 1;
            $data2->save();
        }
        return redirect()->route('admin.history.index')->with('success', 'Marked As Read!');
    }
    public function roomallocationissue()
    {
        $data = RoomIssue::all();
        return view('admin.roomallocation.issue', ['data' => $data]);
    }
    public function roomallocationissueview(string $id)
    {
        //
        $data = RoomIssue::find($id);
        if ($data == null) {
            return redirect()->route('admin.roomallocation.issue')->with('danger', 'Not Found!');
        }
        return view('admin.roomallocation.issueshow', ['data' => $data]);
    }
}
