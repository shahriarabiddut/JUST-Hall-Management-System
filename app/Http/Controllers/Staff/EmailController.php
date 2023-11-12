<?php

namespace App\Http\Controllers\Staff;

use App\Models\Email;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $staff_id = Auth::guard('staff')->user()->id;
        $data = Email::all()->where('staff_id',$staff_id);
        return view('staff.email.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('staff.email.create');
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
        Email::create($formFields);
        if($this->isOnline()){
            $mail_data = [
                'objective'=>$request->objective,
                'recipient'=>$request->email,
                'fromEmail'=>'cseengineerbiddut@gmail.com',
                'fromName'=>$request->name,
                'subject'=>$request->subject,
                'body'=>$request->message
            ];
            \Mail::send('staff.email.email-template',$mail_data,function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'],$mail_data['fromName'])
                        ->subject($mail_data['subject']);
            });
            return redirect('staff/email')->with('success','Email Sent Successfully!');
        }else{

            return redirect()->back()->withInput()->with('error','No Internet Connection');
        }
        
        
    }
    //Check internet Connections
    public function isOnline($site = 'https://youtube.com'){
        if(@fopen($site,'r')){
            return true;
        }else{
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
        return view('staff.email.show',['data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = Email::find($id);
        $data->delete();
        return redirect('staff/email')->with('danger','Email Data has been deleted Successfully!');
    }

    public function paymentEmail(string $id,string $amount,string $staff_id,string $status)
    {
        
        
        $RecieverData = Student::find($id);
        $RecieverEmail = $RecieverData->email;
        $RecieverName = $RecieverData->name;
        $RecieverAmount = $amount; 
        //accept or reject
        if($status==1){
            $emailObjective = 'Payment Accepted';
            $emailSubject = 'Your Payment Has been Accepted and Added to balance';
            $emailBody = 'Your Payment Has been Accepted and your amount was '.$RecieverAmount.' and Added to balance.Login to check your Current Balance .';

        }elseif($status==2){
            $emailObjective = 'Payment Rejected';
            $emailSubject = 'Your Payment Has been Rejected';
            $emailBody = 'Your Payment Has been Rejected and your amount was '.$RecieverAmount.' .Contact Administrator for support.';
        }else{
            return redirect()->back()->withInput()->with('danger','Server Error');
        }
        //Sending email with information
        if($this->isOnline()){
            $mail_data = [
                'objective'=>$emailObjective,
                'recipient'=>$RecieverEmail,
                'fromEmail'=>'cseengineerbiddut@gmail.com',
                'fromName'=>$RecieverName,
                'subject'=> $emailSubject,
                'body'=>$emailBody
            ];
            \Mail::send('staff.email.email-template-payment',$mail_data,function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'],$mail_data['fromName'])
                        ->subject($mail_data['subject']);
            });

            //Saving data to email history
            $dataEmail = new Email;
            $dataEmail->name = $RecieverName;
            $dataEmail->email = $RecieverEmail;
            $dataEmail->subject = $emailSubject;
            $dataEmail->message = $emailBody;
            $dataEmail->objective = $emailObjective;
            $dataEmail->staff_id = $staff_id;
            $dataEmail->save();
        }else{

            return redirect()->back()->withInput()->with('error','No Internet Connection');
        }
        //Email::create($formFields);
    }
}
