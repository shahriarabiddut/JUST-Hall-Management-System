@extends('staff/layout')
@section('title', 'Issue Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">@if ($data->issue=='roomchange')
                Room Change
            @else
                Leave Room
            @endif issue of  {{ $data->students->name }} - {{ $data->students->rollno }}
            <a href="{{ route('staff.roomallocation.issue') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Issue Type</th>
                        <td>@if ($data->issue=='roomchange')
                            Room Change
                        @else
                            Leave Room
                        @endif</td>
                    </tr>
                    <tr>
                        <th>Reason</th>
                        <td>{{ $data->application }}</td>
                    </tr>
                    <tr>
                        <th>Submission Date</th>
                        <td>{{ $data->created_at->format('F j , Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td   @switch($data->status)
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
                    <tr>
                        <th colspan="2" class="text-center">Student Data</th>
                    </tr>
                        <tr>
                            <th>Student </th>
                                 <td>{{ $data->students->name }} - {{ $data->students->rollno }} </td>
                            </tr>
                        <tr>
                       <th>Room Allocation</th>
                            <td>{{ $data->students->allocatedRoom->rooms->title }} (Seat No. {{ $data->students->allocatedRoom->position }})</td>
                        </tr><tr>
                            <th>Allocation Date </th>
                            <td>{{ $data->students->allocatedRoom->created_at->format('F j,Y') }}</td>
                        </tr>
                        @if ($data->status==0 && Auth::guard('staff')->user()->type != 'staff' && Auth::guard('staff')->user()->type != 'officer')
                        <tr>
                            <td colspan="2">
                                <a href="{{ route('staff.roomallocation.issueacc',$data->id) }}" class="float-left btn btn-success btn-sm m-1"><i class="fa fa-check"> Accept </i></a> 
                                <a href="{{ route('staff.roomallocation.issuerej',$data->id) }}" class="float-right btn btn-danger btn-sm m-1"><i class="fa fa-ban"> Reject </i></a> 
                            </td>
                        </tr>
                        @endif
                        @if ($data->staff!=null)
                        <tr>
                            <th>Responsed by </th>
                                 <td>{{ $data->staff->name }} </td>
                            </tr>
                        <tr>   
                        @endif
                        
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

