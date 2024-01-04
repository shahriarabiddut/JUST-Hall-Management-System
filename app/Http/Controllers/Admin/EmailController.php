<?php

namespace App\Http\Controllers\Admin;

use App\Models\Email;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AdminEmail;
use App\Mail\AllocationEmail;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Email::all();
        return view('admin.email.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.email.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $formFields = $request->validate([
            'staff_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'objective' => 'required',
        ]);
        // The email sending is done using the to method on the Mail facade
        Mail::to($request->email)->send(new AdminEmail($request->message, $request->objective, $request->subject));
    }
    //Check internet Connections
    public function isOnline($site = 'https://youtube.com')
    {
        if (@fopen($site, 'r')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Email::find($id);
        return view('admin.email.show', ['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = Email::find($id);
        $data->delete();
        return redirect('admin/email')->with('danger', 'Email Data has been deleted Successfully!');
    }
    public function RoomAllocationEmail(string $id, string $roomtitle, string $status)
    {

        $RecieverData = Student::find($id);
        $RecieverEmail = $RecieverData->email;
        $RecieverName = $RecieverData->name;
        $RoomTitle = $roomtitle;
        //accept or reject
        if ($status == 1) {
            $emailObjective = 'Your Room Allocation Request Accepted';
            $emailSubject = 'Your Room Allocation Request Accepted ! Contact Hall Provost Soon!';
            $emailBody = 'Your Room Allocation Request has been Accepted by Hall Provost! To get allocated Room no is ' . $RoomTitle . ' please contact Hall Provost . Login to See Further Details.';
        } elseif ($status == 2) {
            $emailObjective = 'Your Room Allocation Request Rejected';
            $emailSubject = 'Your Room Allocation Request Rejected! Contact Hall Provost Soon!';
            $emailBody = 'Your Room Allocation Request has been Rejected by Hall Provost! Please Leave the room Room no ' . $RoomTitle . ' and Login to See Further Details.';
        } elseif ($status == 3) {
            $emailObjective = 'Your Room Allocation Request is on Waiting';
            $emailSubject = 'Your Room Allocation Request is on Waiting! Contact Hall Provost Soon!';
            $emailBody = 'Your Room Allocation Request is on Waiting by Hall Provost! Your requested room was Room no ' . $RoomTitle . ' and Login to See Further Details.';
        } else {
            return redirect()->back()->withInput()->with('danger', 'Server Error');
        }
        //Sending email with information
        if ($this->isOnline()) {
            // The email sending is done using the to method on the Mail facade
            Mail::to($RecieverEmail)->send(new AllocationEmail($emailBody, $emailObjective, $emailSubject));

            //Saving data to email history
            $dataEmail = new Email;
            $dataEmail->name = $RecieverName;
            $dataEmail->email = $RecieverEmail;
            $dataEmail->subject = $emailSubject;
            $dataEmail->message = $emailBody;
            $dataEmail->objective = $emailObjective;
            $dataEmail->staff_id = 0;
            $dataEmail->save();
        } else {

            return redirect()->back()->withInput()->with('error', 'No Internet Connection');
        }
    }
}
