@extends('layout')
@section('title', ' Room Allocation Application Payment ')
@section('content')


    <!-- Page Heading -->
@if ($dataPayment!=null)
    <h1 class="h3 mb-2 text-gray-800">Room Allocation Application Payment</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary ">You have allready Requested</h6>
    </div>
</div>
@else
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Add Payment to Room Allocation Request Application </h3>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
               <p class="text-danger"> {{ $error }} </p>
            @endforeach
            @endif
        <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.roomrequestpaymentstore') }}" id="myForm" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <th>Amount  <span class="text-danger">*</span></th>
                    <td>
                        <input id="myInput" required type="number" min="1" name="amount" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Mobile  <span class="text-danger">*</span></th>
                    <td>
                        <input required id="inputField" type="text" name="mobileno" class="form-control">
                    </td>
                </tr>
                <tr>
                <th>Proof of Slip <span class="text-danger">*</span></th>
                    <td>
                        <input required type="file" accept="image/*" name="proof"  class="form-control">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="hall_id" value="{{ $data->hall_id }}">
                        <input type="hidden" name="type" value="roomrequest">
                        <input type="hidden" name="service_id" value="{{ $data->id }}">
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
    // Get the form, input field, and warning message elements
    const form = document.getElementById('myForm');
    const input = document.getElementById('myInput');
    const warningMessage = document.getElementById('warningMessage');

    // Function to check if the input is negative
    function checkInput() {
        const value = parseFloat(input.value);
        if (value < 0 || isNaN(value)) { // Show warning if input is negative or not a number
            warningMessage.style.display = 'inline';
            return false; // Prevent form submission
        } else {
            warningMessage.style.display = 'none';
            return true; // Allow form submission
        }
    }

    // Listen for input event on the input field
    input.addEventListener('input', checkInput);

    // Listen for form submission
    form.addEventListener('submit', function(event) {
        if (!checkInput()) {
            event.preventDefault(); // Prevent form submission if input is negative
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('myForm').addEventListener('submit', function(event) {
            let input2 = document.getElementById('inputField').value;
            let pattern = /^[0-9]+$/;
        
            if (!pattern.test(input2)) {
                alert('Use Valid Mobile Number!');
                event.preventDefault(); // Prevent form submission if input is invalid
                window.location.reload();
            }
        });
    });
    </script>
    @endsection
@endsection

