@extends('layout')
@section('title', 'Request Room Allocation')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Request Room Allocation</h1>
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
        <h6 class="m-0 font-weight-bold text-primary">Add New Allocation request</h6>
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
                    <th>Select RoomNo</th>
                        <td>
                            <select required name="room_id" class="form-control room_id">
                                <option value="0">--- Select Room No ---</option>
                                @foreach ($rooms as $rm)
                                <option value="{{$rm->id}}">{{$rm->title}} - (Vacancy {{$rm->vacancy}} )</option>
                                @endforeach
                            </select>
                        </td>
                </tr>
                <tr>
                <th>Your Application <span class="text-danger">*</span></th>
                    <td>
                        <textarea name="message" id="" cols="10" rows="20" class="form-control"></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
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
    @endsection
@endsection

