<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HallOption;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        return view('admin.dashboard');
    }
    public function edit()
   {
       $datas = HallOption::all();
       return view('admin.settings.edit',['datas'=>$datas]);
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

       return redirect('admin/settings')->with('success','Settings has been updated Successfully!');
       
   }
    
}
