@extends('staff/layout')
@section('title', 'Staff Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Staff Details of {{ $data->name }} 
            <a href="{{ url('staff/staff') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <th>Photo</th>
                            <td><img width="100" src="{{$data->photo ? asset('storage/'.$data->photo) : url('storage/images/user.png')}}" alt="User Photo"></td>
                        </tr><tr>
                            <th>Email </th>
                                 <td>{{ $data->email }}</td>
                             </tr>
                        <tr>
                       <th>Full Name </th>
                            <td>{{ $data->name }}</td>
                        </tr><tr>
                            <th>Bio </th>
                            <td>{{ $data->bio }}</td>
                        </tr><tr>
                            <th>Address </th>
                            <td>{{ $data->address }}</td>
                        </tr><tr>
                            <th>Phone </th>
                            <td>{{ $data->phone }}</td>
                        </tr><tr>
                            <td colspan="2">
                                <a href="{{ url('staff/staff/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm"><i class="fa fa-edit"> Edit {{ $data->title }} </i></a> <a href="{{ url('staff/staff/'.$data->id.'/change') }}" class="float-right btn btn-info btn-sm mr-2"><i class="fa fa-edit"> Change Email & Password {{ $data->title }} </i></a>
                            </td>
                            
                        </tr>
                        
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

