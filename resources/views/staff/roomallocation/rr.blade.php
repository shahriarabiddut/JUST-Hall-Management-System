<!DOCTYPE html>
<html>
<head>
    @php $data = App\Models\RoomRequest::find($id);  @endphp
    <title>{{ $data->students->rollno }} - Room Request</title>
    <style>
table {
    border-collapse: collapse;
    width: 90%;
    overflow: hidden;
    margin-left: auto;
    margin-right: auto;
}

td, th {
    border: 1px solid #000;
    padding: 8px; 
    text-align: left; 
}

body {
    padding: 20px; 
    text-align: center;
}
.text-center{
    text-align: center;
}
    </style>
</head>
<body>
    @php $application = json_decode($data->application, true); @endphp 
    <table class="table table-bordered" width="100%">
        <tbody>
        <tr>
            <th width="25%" class="text-center"><h4 class="my-5">প্রভোস্ট এর কার্যালয়</h4></th>
            {{-- <td width="50%" colspan="2" class="text-center"><img width="75px" src="{{ asset('img/just.jpg') }}" alt=""></td> --}}
            <td width="50%" colspan="2" class="text-center"><img width="75px" src="{{ file_exists(asset('storage/'.$data->hall->logo)) ? asset('storage/'.$data->hall->logo) : asset('img/just.jpg')  }}" alt=""></td>
            <th width="25%" class="text-center">
                <h3 class="my-5"> {{ $data->hall->banglatitle }}
        </h3></th>
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
            <td colspan="2"><img width="150px" @if ($data->students->photo!=null) src="{{ asset('storage/'.$data->students->photo) }}" @else src="{{ asset('images/user.png') }}" @endif alt="Application Photo"> <br>
                <p>তারিখঃ {{ Carbon\Carbon::today()->format('F j , Y') }} </p></td>
            <th width="20%">আবেদনকারীর স্বাক্ষর</th>
            <td width="30%" ><img  width="125px" src="{{ asset('storage/'.$application['signature']) }}" alt=""></td>
        </tr>
        <tr>
            <td colspan="4"> <h3>প্রভোস্ট <br> {{ $data->hall->banglatitle }} <br> যশোর বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়</h3>
            </td>
        </tr>
        </tbody>
    </table>
</body>
</html>