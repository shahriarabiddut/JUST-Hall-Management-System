@extends('layout')
@section('title', 'Room Request Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Request Details <a onclick="return confirm('Are You Sure?')" href="{{ route('student.roomrequest.destroy',$data->id) }}" class="btn btn-danger btn-sm ml-1 float-right mx-1" title="Remove Data"><i class="fa fa-trash"> Delete Request</i></a> 
                <a href="{{ route('student.generatepdf',Auth::user()->rollno) }}" class="btn btn-info btn-sm ml-1 float-right mx-1"><i class="fa fa-print"> Download PDF </i></a>
            </h3>
            
        </div>
        <div class="card-body">
            <!-- Session Messages Starts -->
            @if(Session::has('success'))
            <div class="p-3 mb-2 bg-success text-white">
                <p>{{ session('success') }} </p>
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="p-3 mb-2 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
            @endif
            <!-- Session Messages Ends -->
            
            <div class="table-responsive" id="myDiv">
                <table class="table table-bordered" width="100%">
                    <tbody>
                    <tr>
                        <th width="25%" class="text-center"><h4 class="my-5">প্রভোস্ট এর কার্যালয়</h4></th>
                        <td width="50%" colspan="2" class="text-center"><img width="75px" src="{{ file_exists(asset('storage/'.$data->hall->logo)) ? asset('storage/'.$data->hall->logo) : asset('img/just.jpg')  }}" alt=""></td>
                        <th width="25%" class="text-center">
                            <h4 class="my-5"> {{ $data->hall->banglatitle }}
                    </h4></th>
                    </tr>
                    <tr>
                        <th>০১.আবেদনকারীর নাম - বাংলায়</th>
                        <td>{{ $application['banglaname'] }}</td>
                        <th> ইংরেজীতে (বড় অক্ষরে)</th>
                        <td>{{ $application['englishname'] }}</td>
                    </tr>
                    <tr>
                        <th>০২. পিতার নাম</th>
                        <td>{{ $application['fathername'] }}</td>
                        <th>০৩. মাতার নাম	</th>
                        <td>{{ $application['mothername'] }}</td>
                    </tr>
                    <tr>
                        <th>০৪. জন্ম তারিখ</th>
                        <td>{{ $application['dob'] }}</td>
                        <th>০৫. জাতীয়তা	</th>
                        <td>{{ $application['nationality'] }}</td>
                    </tr>
                    <tr>
                        <th>০৬.ধর্ম</th>
                        <td>{{ $application['religion'] }}</td>
                        <th>০৭. বৈবাহিক অবস্থা</th>
                        <td>{{ $application['maritalstatus'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="4"> ০৮. স্থায়ী ঠিকানা </th>
                    </tr>
                    <tr>
                        <td>গ্রাম - {{ $application['village'] }}</td>
                        <td>পোষ্ট - {{ $application['postoffice'] }}</td>
                        <td>থানা - {{ $application['thana'] }}</td>
                        <td>জেলা - {{ $application['zilla'] }}</td>
                    </tr>
                    <tr>
                        <th>০৯. অভিভাবকের মোবাইল</th>
                        <td>{{ $application['parentmobile'] }}</td>
                        <th>শিক্ষার্থীর মোবাইল</th>
                        <td>{{ $application['mobile'] }}</td>
                    </tr>
                    <tr>
                        <th>১০. বর্তমান ঠিকানা</th>
                        <td colspan="3">{{ $application['presentaddress'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">১১. আবেদনকারীর বর্তমান আবাসনের ধরনঃ</th>
                        <td colspan="2">{{ $application['applicanthouse'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">১২.পিতা/অভিভাবকের পেশা</th>
                        <td colspan="2">{{ $application['occupation'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="4"> স্থানীয় অভিভাবকের নাম </th>
                    </tr>
                    <tr>
                        <td>নাম - {{ $application['ovivabok'] }}</td>
                        <td>সম্পর্ক - {{ $application['ovivabokrelation'] }} </td>
                        <td>ঠিকানা - {{ $application['ovivabokthikana'] }} </td>
                        <td>মোবাইল নং - {{ $application['ovivabokmobile'] }} </td>
                    </tr>
                
                    <tr>
                        <th colspan="4"> ১৪. প্রয়োজনীয় তথ্যাবলী </th>
                    </tr>
                    <tr>
                        <th>ক.বিভাগের নামঃ</th>
                        <td>{{ $application['department'] }}</td>
                        <th>ছ.GPA (সর্বশেষ) - </th>
                        <td>@isset($application['gpa']){{ $application['gpa'] }}@endisset</td>
                    </tr>
                    <tr>
                        <th>খ.রোল নংঃ</th>
                        <td>{{ $application['rollno'] }}</td>
                        <th>জ.ভর্তির মেধাক্রমঃ </th>
                        <td>@isset($application['meritposition']){{ $application['meritposition'] }}@endisset</td>
                    </tr>
                    <tr>
                        <th>গ.রেজিস্ট্রেশন নংঃ</th>
                        <td>{{ $application['registrationno'] }}</td>
                        <th>ঝ.HSC GPA - </th> 
                        <td>@isset($application['hsc']){{ $application['hsc'] }}@endisset</td>
                    </tr>
                    <tr>
                        <th>ঘ.শিক্ষাবর্ষঃ</th> 
                        <td>{{ $application['session'] }}</td>
                        <th>ঞ.HSC কলেজের নামঃ</th>
                        <td>@isset($application['college']){{ $application['college'] }}@endisset</td>
                    </tr>
                    <tr>
                        <th>ঙ.বর্ষঃ</th>
                        <td>{{ $application['borsho'] }}</td>
                        <th>ট.SSC GPA - </th>
                        <td>@isset($application['ssc']){{ $application['ssc'] }}@endisset</td>
                    </tr>
                    <tr>
                        <th>চ.সেমিস্টারঃ</th>
                        <td>{{ $application['semester'] }}</td>
                        <th>ঠ.SSC স্কুলের নামঃ</th>
                        <td>@isset($application['school']){{ $application['school'] }}@endisset</td>
                    </tr>
                    <tr>
                        <th colspan="2">খেলাধুলা, নাটক, সংগীত ইত্যাদিতে পারদর্শিতার বিবরণ (প্রমাণ সংযুক্ত করতে হবে)</th>
                        <td colspan="2">{{ $application['culture'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">শারীরিক প্রতিবন্ধী কি না? (প্রমাণ করতে হবে)</th>
                        <td colspan="2">{{ $application['otisitic'] }}</td>
                    </tr>
                    
                    <tr>
                        <th colspan="4">সংযুক্তি</th>
                    </tr>
                    <tr>
                        <th>ক) নাগরিক সনদের/জন্ম নিবদ্ধন এর অনুলিপি (ছবি)</th>
                        <td colspan="3"><img src="{{ asset('storage/'.$application['dobsonod']) }}" alt=""></td>

                        
                    </tr>
                    <tr>
                        <th>খ) সর্বশেষ পরীক্ষার নম্বর পত্রের অনুলিপি/প্রথম বর্ষের ভর্তির কাগজপত্রের অনুলিপি। (ছবি)</th>
                        <td colspan="3"><img src="{{ asset('storage/'.$application['academic']) }}" alt=""></td>
                        
                    </tr>
                    <tr>
                        <th>গ) অভিভাবকের মাসিক আয়ের প্রমাণ পত্র। (ছবি)</th>
                        <td colspan="3"><img src="{{ asset('storage/'.$application['earningproof']) }}" alt=""></td>
                        
                    </tr>
                    <tr>
                        <td colspan="2"><img width="150px" @if (Auth::user()->photo!=null) src="{{ asset('storage/'.Auth::user()->photo) }}" @else src="{{ asset('images/user.png') }}" @endif alt="Application Photo"> <br>
                            <p>তারিখঃ {{ Carbon\Carbon::today()->format('F j , Y') }} </p></td>
                        <th width="20%">আবেদনকারীর স্বাক্ষর</th>
                        <td width="30%" ><img  width="125px" src="{{ asset('storage/'.$application['signature']) }}" alt=""></td>
                    </tr>
                    <tr>
                        <td colspan="4"> <h3>প্রভোস্ট <br> {{ Auth::user()->roomrequest->hall->banglatitle }} <br> যশোর বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়</h3>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">

                <table class="table table-bordered" width="100%">  
                    <tr>
                        <th style="width: 30%;">Status</th>
                        
                        @if ($data->status=='1')
                        <td class="bg-success text-white"> Accepted </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning text-white"> On Waiting List </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger text-white"> Rejected </td>
                        @else
                        <td> Requested </td>
                        @endif
                        
                    </tr>
                    <tr>    
                        @if ($data->status=='1')
                        <th> Accepted Date </th>
                        @elseif($data->status=='0')
                        <th> Listed Date </th>
                        @elseif($data->status=='2')
                        <th> Rejected Date</th>
                        @else
                        <th> Last Checked Date </th>
                        @endif
                        @if ($data->status=='1')
                        <td> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @elseif($data->status=='0')
                        <td> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @elseif($data->status=='2')
                        <td> {{ $data->updated_at->format('F j, Y - H:i:s') }}</td>
                        @else
                        <td> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Payment Details </h3>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">  
                    @if ($dataPayment == null)
                    <tr>
                        <td colspan="2">
                            <a href="{{ route('student.roomrequest.roomrequestpayment') }}" class="float-right btn btn-info btn-block" title="Edit Data"> <i class="fa fa-edit"> Add Payment Slip </i></a>
                        </td>
                    </tr>
                    @else
                    
                    <tr>
                        <th>Status</th>
                        @switch($dataPayment->status)
                                @case('Processing')
                                   <td class="bg-warning text-white"> Processing</td>
                                       @break
                                @case('Completed')
                                <td class="bg-warning text-white"> Completed</td>
                                    @break
                                @case('Accepted')
                                <td class="bg-success text-white"> Accepted by {{ $dataPayment->staff->name }}</td>
                                    @break
                                @case('Rejected')
                                <td class="bg-danger text-white"> Rejected by {{ $dataPayment->staff->name }}</td>
                                    @break
                                @default
                                   <td>{{$dataPayment->status}}</td>
                            @endswitch
                        
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{ $dataPayment->amount }}</td>
                    </tr><tr>
                        <th>Payment Proof</th>
                        <td><img src="{{ asset('storage/'.$dataPayment->proof) }}" alt=""> </td>
                    </tr>
                    <tr>
                        <th>Payment Date</th>
                        <td>{{ $data->created_at->format('F j,Y') }}</td>
                    </tr>
                    <tr>
                    <td colspan="2">
                        <a onclick="return confirm('Are You Sure?')" href="{{ route('student.roomrequestpayment.destroy',$dataPayment->id) }}" class="btn btn-danger btn-sm ml-1" title="Remove Data"><i class="fa fa-trash"></i></a>
                    </td>
                    </tr>
                    @endif
                </table>
            </div>
            
        </div>
    </div>
    
    @section('scripts')
    @endsection
@endsection
