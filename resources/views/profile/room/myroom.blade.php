@extends('layout')
@section('title', 'Student Dashboard')

@section('content')
@if ($data)
    <!-- Page Heading -->
    @if(Session::has('danger'))
    <div class="p-3 mb-2 bg-danger text-white">
        <p>{{ session('danger') }} </p>
    </div>
    @endif 
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Room Allocation Details of {{ Auth::user()->name }} 
            </h4>
        </div>
        <div class="card-body">
            @if (Auth::user()->allocatedRoom->status==0)
                Room Allocation Removed from Hall!
            @else
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <th> Room No </th>
                            <td>{{ $rooms->title }}</td>
                             </tr>
                        <tr>
                            <th>Student Name </th>
                            <td>{{ Auth::user()->name }}</td>
                        </tr><tr>
                            <th>Student Roll</th>
                            <td>{{ Auth::user()->rollno }}</td>
                        </tr><tr>
                            <th>Allocation Date </th>
                            <td>{{ $data->created_at->format('F j , Y') }} </td>
                        </tr><tr>
                            <th>Position </th>
                            <td>{{ $data->position }}</td>
                        </tr>
                        <tr>
                                <th>Room Mates</th>
                                <td>
                                    <table>
                                        @foreach ( $rooms->allocatedseats as $key => $allocatedseats  )
                                        <tr>
                                            @if($allocatedseats->status!=0)
                                            <td width="50%">{{ $allocatedseats->position }}.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }} </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                      </table>
                                </td>
                            
                        </tr>
                        
                </table>
            </div>
            @endif
        </div>
    </div>
@else
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">No Room Allocations Found! 
        
    </div>
</div>
@endif

@section('scripts')
@endsection
@endsection