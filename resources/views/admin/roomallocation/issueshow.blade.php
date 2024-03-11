@extends('admin/layout')
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
            <a href="{{ route('admin.roomallocation.issue') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
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
                        <th>Application</th>
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
                            <th>Hall </th>
                                 <td>{{ $data->students->hall->title }} </td>
                        </tr>
                        <tr>
                            <th>Student </th>
                            <td>{{ $data->students->name }} - {{ $data->students->rollno }} </td>
                        </tr>
                        <tr>
                        <tr>
                       <th>Room Allocation</th>
                            <td>{{ $data->students->allocatedRoom->rooms->title }} (Seat No. {{ $data->students->allocatedRoom->position }})</td>
                        </tr><tr>
                            <th>Allocation Date </th>
                            <td>{{ $data->students->allocatedRoom->created_at->format('F j,Y') }}</td>
                        </tr>
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

