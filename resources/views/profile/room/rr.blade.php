<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Siyam%20Rupali&display=swap');

    body {
        font-family: 'Siyam Rupali', sans-serif;
    }</style>
        <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
<div class="card shadow mb-4">
        <div class="card-body">
            
            <div class="table-responsive" id="myDiv">
                <table class="table table-bordered" width="100%" >
                    <tbody>
                    <tr>
                        <th class="text-center"><h4 class="my-5">প্রভোস্ট এর কার্যালয়</h4></th>
                        <td colspan="2" class="text-center"><img width="75px" src="{{ asset('storage/'.Auth::user()->roomrequest->hall->logo) }}" alt=""></td>
                        <th class="text-center">
                            <h4 class="my-5"> {{ Auth::user()->roomrequest->hall->banglatitle }}
                    </h4></th>
                    </tr>
                    @php $adpplication = json_decode(Auth::user()->roomrequest->application, true); @endphp 
                    <tr>
                        <th colspan="3"></th>
                        <td class="text-center"><img width="150px" @if (Auth::user()->photo!=null) src="{{ asset('storage/'.Auth::user()->photo) }}" @else src="{{ asset('images/user.png') }}" @endif alt="Application Photo"></td>
                    </tr>
                    <tr>
                        <th>০১.আবেদনকারীর নাম - বাংলায়</th>
                        <td>{{ $adpplication['banglaname'] }}</td>
                        <th> ইংরেজীতে (বড় অক্ষরে)</th>
                        <td>{{ $adpplication['englishname'] }}</td>
                    </tr>
                    <tr>
                        <th>০২. পিতার নাম</th>
                        <td>{{ $adpplication['fathername'] }}</td>
                        <th>০৩. মাতার নাম	</th>
                        <td>{{ $adpplication['mothername'] }}</td>
                    </tr>
                    <tr>
                        <th>০৪. জন্ম তারিখ</th>
                        <td>{{ $adpplication['dob'] }}</td>
                        <th>০৫. জাতীয়তা	</th>
                        <td>{{ $adpplication['nationality'] }}</td>
                    </tr>
                    <tr>
                        <th>০৬.ধর্ম</th>
                        <td>{{ $adpplication['religion'] }}</td>
                        <th>০৭. বৈবাহিক অবস্থা</th>
                        <td>{{ $adpplication['maritalstatus'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="4"> ০৮. স্থায়ী ঠিকানা </th>
                    </tr>
                    <tr>
                        <td>গ্রাম - {{ $adpplication['village'] }}</td>
                        <td>পোষ্ট - {{ $adpplication['postoffice'] }}</td>
                        <td>থানা - {{ $adpplication['thana'] }}</td>
                        <td>জেলা - {{ $adpplication['zilla'] }}</td>
                    </tr>
                    <tr>
                        <th>০৯. অভিভাবকের মোবাইল</th>
                        <td>{{ $adpplication['parentmobile'] }}</td>
                        <th>শিক্ষার্থীর মোবাইল</th>
                        <td>{{ $adpplication['mobile'] }}</td>
                    </tr>
                    <tr>
                        <th>১০. বর্তমান ঠিকানা</th>
                        <td colspan="3">{{ $adpplication['presentaddress'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">১১. আবেদনকারীর বর্তমান আবাসনের ধরনঃ</th>
                        <td colspan="2">{{ $adpplication['applicanthouse'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">১২.পিতা/অভিভাবকের পেশা</th>
                        <td colspan="2">{{ $adpplication['occupation'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="4"> স্থানীয় অভিভাবকের নাম </th>
                    </tr>
                    <tr>
                        <td>নাম - {{ $adpplication['ovivabok'] }}</td>
                        <td>সম্পর্ক - {{ $adpplication['ovivabokrelation'] }} </td>
                        <td>ঠিকানা - {{ $adpplication['ovivabokthikana'] }} </td>
                        <td>মোবাইল নং - {{ $adpplication['ovivabokmobile'] }} </td>
                    </tr>
                    <tr>
                        <th colspan="4"> ১৪. প্রয়োজনীয় তথ্যাবলী </th>
                    </tr>
                    <tr>
                        <th>ক.বিভাগের নামঃ</th>
                        <td>{{ $adpplication['department'] }}</td>
                        <th>ছ.GPA (সর্বশেষ) - </th>
                        <td>{{ $adpplication['gpa'] }}</td>
                    </tr>
                    <tr>
                        <th>খ.রোল নংঃ</th>
                        <td>{{ $adpplication['rollno'] }}</td>
                        <th>জ.ভর্তির মেধাক্রমঃ </th>
                        <td>{{ $adpplication['meritposition'] }}</td>
                    </tr>
                    <tr>
                        <th>গ.রেজিস্ট্রেশন নংঃ</th>
                        <td>{{ $adpplication['registrationno'] }}</td>
                        <th>ঝ.HSC GPA - </th> 
                        <td>{{ $adpplication['hsc'] }}</td>
                    </tr>
                    <tr>
                        <th>ঘ.শিক্ষাবর্ষঃ</th> 
                        <td>{{ $adpplication['session'] }}</td>
                        <th>ঞ.HSC কলেজের নামঃ</th>
                        <td>{{ $adpplication['college'] }}</td>
                    </tr>
                    <tr>
                        <th>ঙ.বর্ষঃ</th>
                        <td>{{ $adpplication['borsho'] }}</td>
                        <th>ট.SSC GPA - </th>
                        <td>{{ $adpplication['ssc'] }}</td>
                    </tr>
                    <tr>
                        <th>চ.সেমিস্টারঃ</th>
                        <td>{{ $adpplication['semester'] }}</td>
                        <th>ঠ.SSC স্কুলের নামঃ</th>
                        <td>{{ $adpplication['school'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">খেলাধুলা, নাটক, সংগীত ইত্যাদিতে পারদর্শিতার বিবরণ (প্রমাণ সংযুক্ত করতে হবে)</th>
                        <td colspan="2">{{ $adpplication['culture'] }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">শারীরিক প্রতিবন্ধী কি না? (প্রমাণ করতে হবে)</th>
                        <td colspan="2">{{ $adpplication['otisitic'] }}</td>
                    </tr>
                    
                    <tr>
                        <th colspan="4">সংযুক্তি</th>
                    </tr>
                    <tr>
                        <th>ক) নাগরিক সনদের/জন্ম নিবদ্ধন এর অনুলিপি (ছবি)</th>
                        <td colspan="3"><img src="{{ asset('storage/'.$adpplication['dobsonod']) }}" alt=""></td>

                        
                    </tr>
                    <tr>
                        <th>খ) সর্বশেষ পরীক্ষার নম্বর পত্রের অনুলিপি/প্রথম বর্ষের ভর্তির কাগজপত্রের অনুলিপি। (ছবি)</th>
                        <td colspan="3"><img src="{{ asset('storage/'.$adpplication['academic']) }}" alt=""></td>
                        
                    </tr>
                    <tr>
                        <th>গ) অভিভাবকের মাসিক আয়ের প্রমাণ পত্র। (ছবি)</th>
                        <td colspan="3"><img src="{{ asset('storage/'.$adpplication['earningproof']) }}" alt=""></td>
                        
                    </tr>
                    <tr>
                        <th width="25%">তারিখঃ</th>
                        <td width="25%">{{ Carbon\Carbon::today()->format('F j , Y') }}</td>
                        <th width="25%">আবেদনকারীর স্বাক্ষর</th>
                        <td width="25%"><img src="{{ asset('storage/'.$adpplication['signature']) }}" alt=""></td>
                    </tr>
                    <tr>
                        <td colspan="4"> <h5>প্রভোস্ট <br> {{ Auth::user()->roomrequest->hall->banglatitle }} <br> যশোর বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়</h5>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        </div>
        </div>
    </div>

    </body>

    </html>