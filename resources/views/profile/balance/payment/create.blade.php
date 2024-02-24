@extends('layout')
@section('title', 'Add new Payment')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Payment Details to Add Balance
            <a href="{{ url('student/payment') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('student.ssl.pay') }}" id="myForm"  enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Mobile <span class="text-danger">(Only if used mobile banking)</span></th>
                        <td><input required name="mobile" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Amount<span class="text-danger">*</span></th>
                        <td><input required name="amount" type="number" min="1" class="form-control" id="myInput" ></td>
                    </tr>
                        <td colspan="2">
                            <input name="student_id" type="hidden" value="{{ Auth::user()->id }}">
                            <input name="createdby" type="hidden" value="{{ Auth::user()->name }} : {{ Auth::user()->rollno }}">
                            <input name="email" type="hidden" value="{{ Auth::user()->email }}">
                            <button type="submit" class="btn btn-primary btn-block">Pay</button>
                        </td>
                    </tr>
                
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

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
    
        </script>
    @endsection
@endsection

