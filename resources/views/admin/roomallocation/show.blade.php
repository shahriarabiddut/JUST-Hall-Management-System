@extends('admin/layout')
@section('title', 'Room Allocation Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Allocation Details of {{ $data->students->name }} 
            <a href="{{ url('admin/roomallocation') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th> Hall </th>
                        <th>{{ $data->hall->title }}</th>
                    </tr>    
                    <tr>
                            <th> Room No </th>
                            <td>{{ $data->rooms->title }}</td>
                    </tr><tr>
                        <th>Seat No </th>
                        <td>{{ $data->position }}</td>
                    </tr>
                    <tr>
                        <th>Student Name </th>
                        <td>{{ $data->students->name }}</td>
                    </tr><tr>
                        <th>Student Roll</th>
                        <td>{{ $data->students->rollno }}</td>
                    </tr><tr>
                        <th>Allocation Date </th>
                        <td>{{ $data->created_at->format("F j, Y H:i:s") }} </td>
                    </tr><tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/roomallocation/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm m-1" title="Remove Data"><i class="fa fa-trash"> Delete Room Allocation</i></a>
                            <a href="{{ url('admin/roomallocation/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm m-1" title="Edit Data"> <i class="fa fa-edit"> Edit {{ $data->title }} </i></a> 
                        </td>
                        
                    </tr>
                        
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

