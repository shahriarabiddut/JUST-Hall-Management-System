@extends('layout')
@section('title', 'Request Room Allocation')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Request Room Allocation</h1>
@if ($sorryAllocatedSeat)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary ">You have allready Requested</h6>
    </div>
</div>
@else
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Add New Allocation request</h3>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
               <p class="text-danger"> {{ $error }} </p>
            @endforeach
            @endif
        <form method="POST" action="{{ route('student.roomrequeststore') }}" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <th>Rules</th>
                        <td>
                            To Add Line break use &lt;br&gt; .
                        </td>
                </tr>
                <tr>
                <th>Your Application <span class="text-danger">*</span></th>
                    <td>
                        <textarea name="message" id="" cols="10" rows="20" class="form-control">[Date]<br>
[Provost's Name]<br>
[Hall Name]<br>
[Hall Address]<br>
[City, State, Zip Code]<br>
<br>
Subject: Request for Hall Room Allocation<br>
<br>
Dear [Provost's Name],<br>
<br>
I hope this letter finds you well. I am writing to request the allocation of a room in [Hall Name] for the upcoming academic year [Year]. As a [mention your current academic status: undergraduate/graduate/postgraduate] student at [Your University/Institution Name], I am eager to reside in the hall and be a part of its vibrant community.<br>
<br>
I am aware of the esteemed reputation of [Hall Name] and its commitment to providing a conducive environment for academic excellence and personal growth. I believe that residing in the hall will not only offer me a comfortable living space but also provide invaluable opportunities for interaction with fellow students and participation in various hall activities.<br>
<br>
Moreover, living in [Hall Name] aligns with my academic and personal goals. I am keen on contributing positively to the hall community through active involvement in hall events, volunteering initiatives, and fostering a supportive environment for all residents.<br>
<br>
In light of the above, I kindly request your assistance in allocating a room for me in [Hall Name] for the upcoming academic year. I am flexible regarding the room type and willing to abide by all hall regulations and guidelines to ensure a harmonious living environment for all residents.<br>
<br>
Attached to this letter, please find the required documents, including my student ID, proof of enrollment, and any other relevant information. I am also available for an interview or to provide any further details that may be necessary to process my request.<br>
<br>
Thank you for considering my application. I am eagerly looking forward to the opportunity to reside in [Hall Name] and contribute to its vibrant community. Please do not hesitate to contact me if you require any additional information.<br>
<br>
Yours sincerely,<br>
<br>
[Your Name]<br>
[Your Student ID]<br>
[Your University/Institution Name] <br>
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        </div>
    </div>
</div>
@endif
   

    @section('scripts')
    @endsection
@endsection

