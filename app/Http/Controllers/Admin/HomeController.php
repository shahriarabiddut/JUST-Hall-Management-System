<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\HallOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        $data->value = $request->value;
        $data->save();

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
}
