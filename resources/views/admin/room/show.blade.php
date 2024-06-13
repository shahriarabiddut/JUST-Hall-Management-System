@extends('admin/layout')
@section('title', 'Room Details')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Details of <span class="bg-warning px-1"> {{ $data->title }}  </span> 
            <a href="{{ url('admin/rooms') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Hall</th>
                        <th>
                            @if ($data->hall==null)
                                No Hall Assigned
                            @else
                            {{ $data->hall->title }}
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr>
                    <tr>
                        <th>Room Type</th>
                        <td>
                            @if ($data->roomtype==null)
                                    Room Type N/A
                                @else
                                {{ $data->roomtype->title }}
                                @endif</td>
                    </tr>
                    <tr>
                        <th>Total Seats</th>
                        <td>{{ $data->totalseats }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/rooms/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm" title="Remove Data"><i class="fa fa-trash"> Delete </i></a>
                            <a href="{{ url('admin/rooms/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm" title="Edit Data"> <i class="fa fa-edit"> Edit {{ $data->title }}  </i></a>
                        </td>
                        
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

