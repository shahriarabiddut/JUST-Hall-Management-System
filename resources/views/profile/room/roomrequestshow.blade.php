@extends('layout')
@section('title', 'Room Request Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Request Details </h6>
            
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
                        <th>Status</th>
                        
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
                        <td>{{ Auth::user()->name }}</td>
                    </tr><tr>
                        <th>Detail</th>
                        <td>{{ Auth::user()->rollno }} </td>
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
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ route('student.roomrequest.destroy',$data->id) }}" class="btn btn-danger btn-sm ml-1"><i class="fa fa-trash"></i></a>
                            <a href="{{ route('student.roomrequest.destroy',$data->id) }}" class="float-right btn btn-info btn-sm"><i class="fa fa-edit"> Edit Room Request </i></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection
