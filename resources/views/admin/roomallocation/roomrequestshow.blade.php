@extends('admin/layout')
@section('title', 'Room Request Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Request Details 
                <a href="{{ route('admin.roomallocation.roomrequests') }}" class="float-right btn btn-success btn-sm" target="_self"> <i class="fa fa-arrow-left m-1 p-1"> </i>View All Room Requests</a> 
            </h6>
            
        </div>
        <div class="card-body">
            <!-- Session Messages Starts -->
            @if(Session::has('success'))
            <div class="p-3 mb-2 bg-success text-white">
                <p>{{ session('success') }} </p>
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="p-3 mb-2 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
            @endif
            <!-- Session Messages Ends -->
            
            <div class="table-responsive">

                <table class="table table-bordered" width="100%">  
                    <tr>
                        <th style="width: 30%;">Status</th>
                        
                        @if ($data->status=='1')
                        <td class="bg-success"> Accepted </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning"> On Queue </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger"> Rejected </td>
                        @else
                        <td> Requested </td>
                        @endif
                        
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $data2->name }}</td>
                    </tr><tr>
                        <th>Roll</th>
                        <td>{{ $data2->rollno }} </td>
                    </tr><tr>
                        <th>Room no</th>
                        <td>{{ $data->rooms->title }} - {{ $data->rooms->RoomType->title }} type </td>
                    </tr>
                    <tr>
                        <th>Application</th>
                        <td>{{ $data->message }}</td>
                    </tr><tr>
                        <th>Application Date</th>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                    <tr>    
                        @if ($data->status=='1')
                        <th class="bg-success"> Accepted Date </th>
                        @elseif($data->status=='0')
                        <th class="bg-warning"> Listed Date </th>
                        @elseif($data->status=='2')
                        <th class="bg-danger"> Rejected Date</th>
                        @else
                        <th> Last Checked Date </th>
                        @endif
                        @if ($data->status=='1')
                        <td class="bg-success"> {{ $data->updated_at }} </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning"> {{ $data->updated_at }} </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger"> {{ $data->updated_at }}</td>
                        @else
                        <td> {{ $data->updated_at }} </td>
                        @endif
                    </tr>
                    <tr>
                        <th class="text-center">
                            @if ($data->status!='1')
                            <a href="{{ url('admin/roomallocation/accept/'.$data->id) }}" class="btn btn-success btn-sm m-1"><i class="fa fa-check"> Accept </i></a>
                            @endif
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/roomallocation/list/'.$data->id) }}" class="btn btn-warning btn-sm m-1"><i class="fa fa-list" aria-hidden="true"> List </i></a>
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/roomallocation/ban/'.$data->id) }}" class="btn btn-danger btn-sm m-1"><i class="fa fa-ban" aria-hidden="true"> Reject </i></a>
                        </th>
                        <td>
                            @if ($data->status!='1')
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/roomallocation/allocate/'.$data->id) }}" class="btn btn-info btn-sm"><i class="fa fa-check" aria-hidden="true"> Allocate Sit For {{ $data2->rollno }} - Room No {{ $data->rooms->title }} </i></a>
                            @endif
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection
