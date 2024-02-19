@extends('layout')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
@section('title', 'Room Request Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Request Details <a onclick="return confirm('Are You Sure?')" href="{{ route('student.roomrequest.destroy',$data->id) }}" class="btn btn-danger btn-sm ml-1 float-right mx-1"><i class="fa fa-trash"> Delete Request</i></a> <button class="btn btn-info btn-sm ml-1 float-right mx-1" onclick="convertDivToPDF()"><i class="fa fa-print"> Get PDF </i></button></h3>
            
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
                            <h4 class="my-5"> {{ $data->hall->banglatitle }}
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
                            <a href="{{ route('student.roomrequest.roomrequestpayment') }}" class="float-right btn btn-info btn-block"><i class="fa fa-edit"> Add Payment Slip </i></a>
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
                        <a onclick="return confirm('Are You Sure?')" href="{{ route('student.roomrequestpayment.destroy',$dataPayment->id) }}" class="btn btn-danger btn-sm ml-1"><i class="fa fa-trash"></i></a>
                    </td>
                    </tr>
                    @endif
                </table>
            </div>
            
        </div>
    </div>
    
    @section('scripts')
    {{-- <script>
        function printDiv() {
            var divContents = document.getElementById("myDiv").innerHTML;
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Print DIV</title></head><body>');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script> --}}
    <script>
        function convertDivToPDF() {
          const content = document.getElementById('myDiv');
          const filename = '{{ $data->rollno }}' + ' Room Request';
          html2pdf()
            .from(content)
            .save(filename + '.pdf');
        }
    </script>
    @endsection
@endsection
