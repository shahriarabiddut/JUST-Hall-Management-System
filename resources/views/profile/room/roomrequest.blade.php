@extends('layout')
@section('title', 'Request Room Allocation')
@section('content')


    <!-- Page Heading -->
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
        <h3 class="m-0 font-weight-bold text-primary">Add New Room Allocation Request</h3>
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
                        <th colspan="4">০১.আবেদনকারীর নাম</th>
                    </tr>
                <tr>
                    <th> বাংলায়</th>
                    <td><input type="text" required name="banglaname" value="{{ old('banglaname') }}" class="form-control"></td>
                    <th> ইংরেজীতে (বড় অক্ষরে)</th>
                    <td><input type="text" required name="englishname" class="form-control" value="{{ Auth::user()->name }}"></td>
                </tr>
                <tr>
                    <th>০২. পিতার নাম</th>
                    <td><input type="text" required name="fathername" value="{{ old('fathername') }}" class="form-control"></td>
                    <th>০৩. মাতার নাম	</th>
                    <td><input type="text" required name="mothername" value="{{ old('mothername') }}" class="form-control"></td>
                </tr>
                <tr>
                    <th>০৪. জন্ম তারিখ</th>
                    <td><input type="date" required name="dob" value="{{ old('dob') }}" class="form-control"></td>
                    <th>০৫. জাতীয়তা	</th>
                    <td><input type="text" name="nationality" class="form-control"></td>
                </tr>
                <tr>
                    <th>০৬.ধর্ম</th>
                    <td><input type="text" name="religion" class="form-control"></td>
                    <th>০৭. বৈবাহিক অবস্থা</th>
                    <td><input type="text" name="maritalstatus" class="form-control"></td>
                </tr>
                <tr>
                    <th colspan="4"> ০৮. স্থায়ী ঠিকানা </th>
                </tr>
                <tr>
                    <td><label for="">গ্রামঃ </label><input type="text" name="village" class="form-control"></td>
                    <td><label for="">পোষ্টঃ </label><input type="text" name="po" class="form-control"></td>
                    <td><label for="">থানাঃ </label><input type="text" name="thana" class="form-control"></td>
                    <td><label for="">জেলাঃ </label><input type="text" name="zilla" class="form-control"></td>
                </tr>
                <tr>
                    <th>০৯. অভিভাবকের মোবাইল</th>
                    <td><input type="text" name="parentmobile" class="form-control"></td>
                    <th>শিক্ষার্থীর মোবাইল</th>
                    <td><input type="text" name="mobile" class="form-control" value="{{ Auth::user()->mobile }}"></td>
                </tr>
                <tr>
                    <th>১০. বর্তমান ঠিকানা</th>
                    <td colspan="3"><textarea name="presentaddress" rows="2" class="form-control"></textarea></td>
                </tr>
                <tr>
                    <th colspan="2">১১. আবেদনকারীর বর্তমান আবাসনের ধরনঃ</th>
                    <td colspan="2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="নিজ গৃহে" name="applicanthouse">
                            <label class="form-check-label" for="inlineRadio1">নিজ গৃহে</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="মেস" name="applicanthouse">
                            <label class="form-check-label" for="inlineRadio2">মেস</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="অন্যান্য" name="applicanthouse">
                            <label class="form-check-label" for="inlineRadio3">অন্যান্য</label>
                          </div>
                        </td>
                </tr>
                <tr>
                    <th colspan="2">১২. পিতা/অভিভাবকের পেশা</th>
                    <td colspan="2"><input type="text" name="occupation" class="form-control"></td>
                </tr>
                <tr>
                    <th colspan="4"> স্থানীয় অভিভাবকের নাম </th>
                </tr>
                <tr>
                    <td><label for="">নাম </label><input type="text" name="ovivabok" class="form-control"></td>
                    <td><label for="">সম্পর্কঃ  </label><input type="text" name="ovivabokrelation" class="form-control"></td>
                    <td><label for="">ঠিকানাঃ  </label><input type="text" name="ovivabokthikana" class="form-control"></td>
                    <td><label for="">মোবাইল নং - </label><input type="text" name="ovivabokmobile" class="form-control"></td>
                </tr>
                <tr>
                    <th colspan="4"> ১৪. প্রয়োজনীয় তথ্যাবলী </th>
                </tr>
                <tr>
                    <th>ক.বিভাগের নামঃ</th>
                    <td><input type="text" name="department" class="form-control" value="{{ Auth::user()->dept }}"></td>
                    <th>খ.রোল নংঃ</th>
                    <td><input type="text" name="rollno" class="form-control" value="{{ Auth::user()->rollno }}"></td>
                </tr>
                <tr>
                    <th>গ.রেজিস্ট্রেশন নংঃ</th>
                    <td><input type="text" name="registrationno" class="form-control" ></td>
                    <th>ঘ.শিক্ষাবর্ষঃ</th>
                    <td><input type="text" name="session" class="form-control" value="{{ Auth::user()->session }}"></td>
                </tr>
                <tr>
                    <th>ঙ.বর্ষঃ</th>
                    <td><input type="text" name="borsho" class="form-control" ></td>
                    <th>চ.সেমিস্টারঃ</th>
                    <td><input type="text" name="semester" class="form-control" value="{{ Auth::user()->rollno }}"></td>
                </tr>
                <tr>
                    <th colspan="2">খেলাধুলা, নাটক, সংগীত ইত্যাদিতে পারদর্শিতার বিবরণ (প্রমাণ সংযুক্ত করতে হবে)</th>
                    <td colspan="2"><textarea name="culture" rows="3" class="form-control" ></textarea></td>
                </tr>
                <tr>
                    <th colspan="2">শারীরিক প্রতিবন্ধী কি না? (প্রমাণ করতে হবে)</th>
                    <td colspan="2"><textarea name="otisitic" rows="2" class="form-control"></textarea></td>
                </tr>
                
                <tr>
                    <th colspan="4">সংযুক্তি</th>
                </tr>
                <tr>
                    <th>ক) নাগরিক সনদের/জন্ম নিবদ্ধন এর অনুলিপি (ছবি)</th>
                    <td colspan="3"><input name="dobsonod" type="file" class="form-control" accept="image/*" ></td>
                    
                </tr>
                <tr>
                    <th>খ) সর্বশেষ পরীক্ষার নম্বর পত্রের অনুলিপি/প্রথম বর্ষের ভর্তির কাগজপত্রের অনুলিপি। (ছবি)</th>
                    <td colspan="3"><input name="academic" type="file" class="form-control" accept="image/*" ></td>
                    
                </tr>
                <tr>
                    <th>গ) অভিভাবকের মাসিক আয়ের প্রমাণ পত্র। (ছবি)</th>
                    <td colspan="3"><input name="earning" type="file" class="form-control" accept="image/*" ></td>
                    
                </tr>
                <tr>
                    <th width="25%">তারিখঃ</th>
                    <td width="25%"><input type="text" readonly name="applicationdate" class="form-control" value="{{ Carbon\Carbon::today()->format('F j , Y') }}"></td>
                    <th width="25%">আবেদনকারীর স্বাক্ষর</th>
                    <td width="25%"><input name="signature" type="file" id="imageInput" class="form-control" accept="image/*" onchange="validateFile()">
                    <p>image with dimensions up to 300x300 pixels</p></td>
                </tr>
                <tr>
                    <td colspan="4">
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
    <script>
        function validateFile() {
            const fileInput = document.getElementById('imageInput');
            const file = fileInput.files[0];
            const maxSizeInBytes = 1 * 1024 * 1024; // 5 MB
            const maxWidth = 300; // Maximum width in pixels
            const maxHeight = 300; // Maximum height in pixels
        
            if (file && file.type.startsWith('image/') && file.size <= maxSizeInBytes) {
                const img = new Image();
                img.onload = function() {
                    if (img.width <= maxWidth && img.height <= maxHeight) {
                        // Valid dimensions
                        return true;
                    } else {
                        // Invalid dimensions
                        alert('Please select an image with dimensions up to 300x300 pixels.');
                        fileInput.value = ''; // Clear the file input
                        return false;
                    }
                };
                img.src = URL.createObjectURL(file);
            } else {
                // Invalid file
                alert('Please select a valid image file under 1MB.');
                fileInput.value = ''; // Clear the file input
                return false;
            }
        }
        </script>
    @endsection
@endsection

