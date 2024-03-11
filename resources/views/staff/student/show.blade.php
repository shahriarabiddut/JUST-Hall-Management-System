@extends('staff/layout')
@section('title', 'Student Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Student Details of {{ $data->name }} 
            <a href="{{ url('staff/student') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <th>Photo</th>
                            <td><img width="100" src="{{$data->photo ? asset('storage/'.$data->photo) : url('images/user.png')}}" alt="User Photo"></td>
                        </tr>
                        <tr>
                            <th>Roll No </th>
                                 <td>{{ $data->rollno }}</td>
                             </tr>
                        <tr>
                       <th>Full Name </th>
                            <td>{{ $data->name }}</td>
                        </tr>
                        <tr>
                            <th>Department </th>
                                 <td>{{ $data->dept }}</td>
                        </tr>
                        <tr>
                            <th>Student Type </th>
                            <td>
                                @if($data->ms==0)
                                Honours
                                @else
                                Masters
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Session </th>
                                 <td>{{ $data->session }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $data->email }}</td>
                        </tr><tr>
                            <th>Mobile No </th>
                            <td>{{ $data->mobile }}</td>
                        </tr><tr>
                            <th>Address</th>
                            <td>{{ $data->address }}</td>
                        </tr>
                        @if ($data->status==0)
                        <tr>
                            <th>Data Remove Date </th>
                            <td>{{ $data->updated_at->format("F j, Y H:i:s") }} </td>
                        </tr>
                        @endif
                        @if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost')
                        <tr>
                            <td colspan="2">
                                <a href="{{ url('staff/student/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm"><i class="fa fa-edit"> Edit {{ $data->title }}  </i></a>
                                
                            </td>
                            
                        </tr>
                        @endif
                        
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

