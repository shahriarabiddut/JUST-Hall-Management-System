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
        <form method="POST" action="{{ route('student.roomrequestpaymentstore') }}" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <th>Amount  <span class="text-danger">*</span></th>
                    <td>
                        <input type="number" name="amount" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Mobile  <span class="text-danger">*</span></th>
                    <td>
                        <input type="text" name="mobileno" class="form-control">
                    </td>
                </tr>
                <tr>
                <th>Proof of Slip <span class="text-danger">*</span></th>
                    <td>
                        <input type="file" name="proof"  class="form-control">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="type" value="roomrequest">
                        <input type="hidden" name="type" value="roomrequest">
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

