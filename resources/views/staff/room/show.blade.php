@extends('staff/layout') 
@section('title', 'Room Details')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Details of <span class="bg-warning px-1"> {{ $data->title }}  </span> 
            <a href="{{ url('staff/rooms') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr>
                    <tr>
                        <th>Room Type</th>
                        <td>{{ $data->roomtype->title }}</td>
                    </tr>
                    <tr>
                        <th>Total Seats</th>
                        <td>{{ $data->totalseats }}</td>
                    </tr>
                    <tr>
                        <th>Total Vacancy</th>
                        <td>{{ $data->vacancy }}</td>
                    </tr>
                    @if (count($data->allocatedseats) !=0)
                    <tr>
                        <th>Allocated Students</th>
                        <td>
                            <table>
                                @foreach ( $data->allocatedseats as $key => $allocatedseats  )
                                <tr>
                                    @if($allocatedseats->status!=0)
                                    <td width="50%">{{ $allocatedseats->position }}.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }} </td>
                                    @endif
                                </tr>
                                @endforeach
                              </table>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/rooms/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm m-1" title="Remove Data"><i class="fa fa-trash"> Delete </i></a>
                            <a href="{{ url('staff/rooms/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm m-1" title="Edit Data"> <i class="fa fa-edit"> Edit {{ $data->title }}  </i></a>
                        </td>
                        
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

