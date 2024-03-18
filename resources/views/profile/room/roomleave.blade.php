@extends('layout')
@section('title', 'Room Leave Application')
@section('content')


    <!-- Page Heading -->
@if(Session::has('danger'))
<div class="p-3 mb-2 bg-danger text-white">
    <p>{{ session('danger') }} </p>
</div>
@endif 
@if(Session::has('success'))
<div class="p-3 mb-2 bg-success text-white">
    <p>{{ session('success') }} </p>
</div>
@endif 
    <!-- DataTales Example -->
    @if (count($roomchanges) != 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">My Room Leave Application
            <a href="{{ route('student.myroom') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View Room Details </a></h3>
        </div>
        @foreach ($roomchanges as $roomchange)
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Reason</th>
                        <td>{{ $roomchange->application }}</td>
                    </tr>
                    <tr>
                        <th>Submission Date</th>
                        <td>{{ $roomchange->created_at->format('F j , Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td   @switch($roomchange->status)
                                @case(1)
                                 class="bg-success text-white"> Accepted
                                    @break
                                @case(1)
                                class="bg-danger text-white"> Rjected
                                    @break
                                @default
                                class="bg-info text-white">
                                    No Reply
                            @endswitch
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Leave Application
            <a href="{{ route('student.myroom') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View Room Details </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.myroom.roomissue') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Reason</th>
                        <td>
                        <textarea name="application" id="" cols="10" rows="4" class="form-control"></textarea>
                        </td>
                    </tr><tr>
                        <td colspan="2">
                            <input type="hidden" name="issue" value="roomleave">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

