@extends('admin/layout')
@section('title', 'Hall Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Hall Details of <span class="bg-warning"> {{ $data->title }} </span> 
            <a href="{{ url('admin/hall') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>logo</th>
                        <td><img width="100" src="{{$data->logo ? asset('storage/'.$data->logo) : url('images/user.png')}}" alt="Hall Logo Photo"></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>
                        @switch($data->type)
                            @case(0)
                                Girls - মেয়েদের হল
                                    @break
                            @case(1)
                                Boys - ছেলেদের হল
                                @break
                        @endswitch
                    </td>
                    </tr>
                    <tr>
                        <th>Bangla Title</th>
                        <td>{{ $data->banglatitle }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr><tr>
                        <th>Provost</th>
                        <td>{{ $data->staff->name }}</td>
                    </tr><tr>
                        <th>Status</th>
                        @switch($data->status)
                            @case(0)
                                <td class="bg-warning text-white"> Disable</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                        @endswitch
                    </tr>
                    {{-- <tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/hall/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"> DELETE</i></a>
                        </td>
                        
                    </tr> --}}
                   
                    
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary"> {{ $data->staff->name }} - Provost ({{ $data->title }})</h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <th>Photo</th>
                            <td><img width="100" src="{{$data->staff->photo ? asset('storage/'.$data->staff->photo) : url('images/user.png')}}" alt="User Photo"></td>
                        </tr><tr>
                            <th>Email </th>
                                 <td>{{ $data->staff->email }}</td>
                             </tr>
                        <tr>
                       <th>Full Name </th>
                            <td>{{ $data->staff->name }}</td>
                        </tr><tr>
                            <th>Bio </th>
                            <td>{{ $data->staff->bio }}</td>
                        </tr><tr>
                            <th>Address </th>
                            <td>{{ $data->staff->address }}</td>
                        </tr><tr>
                            <th>Phone </th>
                            <td>{{ $data->staff->phone }}</td>
                        </tr>
                        
                </table>
            </div>
        </div>
    </div>
    @section('scripts')
    @endsection
@endsection

