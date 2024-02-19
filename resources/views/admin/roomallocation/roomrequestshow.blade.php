@extends('admin/layout')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
@section('title', 'Room Request Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Request Details 
                <a href="{{ route('admin.roomallocation.roomrequests') }}" class="float-right btn btn-success btn-sm  m-1" target="_self"> <i class="fa fa-arrow-left m-1 p-1"> </i>View All Room Requests</a>
                <button class="btn btn-info btn-sm ml-1 float-right  m-1" onclick="convertDivToPDF()"><i class="m-1 p-1 fa fa-print"> Download PDF </i></button> 
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
                <table class="table table-bordered" width="100%" >
                    <tbody>
                    <tr>
                        <th class="text-center"><h4 class="my-5">প্রভোস্ট এর কার্যালয়</h4></th>
                        <td colspan="2" class="text-center"><img width="75px" src="{{ asset('storage/'.$data->hall->logo) }}" alt=""></td>
                        <th class="text-center">
                            <h4 class="my-5">{{ $data->hall->banglatitle }}
                    </h4></th>
                    </tr>
                    <tr>
                        <th colspan="4">০১.আবেদনকারীর নাম</th>
                    </tr>
                    <tr>
                        <th> বাংলায়</th>
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
                        <th>খ.রোল নংঃ</th>
                        <td>{{ $application['rollno'] }}</td>
                    </tr>
                    <tr>
                        <th>গ.রেজিস্ট্রেশন নংঃ</th>
                        <td>{{ $application['registrationno'] }}</td>
                        <th>ঘ.শিক্ষাবর্ষঃ</th> 
                        <td>{{ $application['session'] }}</td>
                    </tr>
                    <tr>
                        <th>ঙ.বর্ষঃ</th>
                        <td>{{ $application['borsho'] }}</td>
                        <th>চ.সেমিস্টারঃ</th>
                        <td>{{ $application['semester'] }}</td>
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
                        <th width="25%">তারিখঃ</th>
                        <td width="25%">{{ Carbon\Carbon::today()->format('F j , Y') }}</td>
                        <th width="25%">আবেদনকারীর স্বাক্ষর</th>
                        <td width="25%"><img src="{{ asset('storage/'.$application['signature']) }}" alt=""></td>
                    </tr>
                    <tr>
                        <td colspan="4"> <h5>প্রভোস্ট <br> {{ $data->hall->banglatitle }} <br> যশোর বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়</h5>
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
                        <td class="bg-success"> Accepted </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning"> On Queue </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger"> Rejected </td>
                        @else
                        <td> Requested </td>
                        @endif
                        
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>
                            @if ($data->students==null)
                                User Deleted
                            @else
                                {{ $data->students->name }} - {{ $data->students->rollno }}
                            @endif
                        </td>
                    </tr><tr>
                        <th>Application Date</th>
                        <td>{{ $data->created_at->format('F j, Y - H:i:s') }}</td>
                    </tr>
                    <tr>    
                        @if ($data->status=='1')
                        <th class="bg-success"> Accepted Date </th>
                        @elseif($data->status=='0')
                        <th class="bg-warning"> Listed Date </th>
                        @elseif($data->status=='2')
                        <th class="bg-danger"> Rejected Date</th>
                        @else
                        <th> Last Checked Date </th>
                        @endif
                        @if ($data->status=='1')
                        <td class="bg-success"> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning"> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger"> {{ $data->updated_at->format('F j, Y - H:i:s') }}</td>
                        @else
                        <td> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @endif
                    </tr>
                    @if (($dataAllocation)!=null)
                        <tr>
                            <td colspan="2"> Room Allocated </td>
                        </tr>
                    @endif
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
                    @if ($dataPayment!=null)
                    
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
                        <td>{{ $dataPayment->created_at->format('F j,Y') }}</td>
                    </tr>
                    
                @else
                <tr>
                    <td colspan="2">
                        No Payment Data Found
                    </td>
                </tr>
                @endif
                </table>
            </div>
            
        </div>
    </div>
    @section('scripts')
    <script>
        $(function(){
         $("#select_student").select2();
        }); 
        $(function(){
         $("#select_room").select2();
        }); 
        $('.js-searchBox').searchBox({ elementWidth: '100%'});
        $('.user_id').searchBox({ elementWidth: '100%'});
        $('.room_id').searchBox({ elementWidth: '100%'});
       </script>
       <script>
        function printDiv() {
            var divContents = document.getElementById("myDiv").innerHTML;
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Print DIV</title></head><body>');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        
    </script>
    <script>
        function convertDivToPDF() {
          const content = document.getElementById('myDiv');
          const filename ="{{ $application['rollno'] }} Room Request";
          html2pdf()
            .from(content)
            .save(filename + '.pdf');
        }
    </script>
    @endsection
@endsection
