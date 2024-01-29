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
                        <th>Room Price</th>
                        <td>{{ $data->roomtype->price }}</td>
                    </tr>
                    <tr>
                        <th>Total Seats</th>
                        <td>{{ $data->totalseats }}</td>
                    </tr>
                    @if (count($data->allocatedseats) !=0)
                    <tr>
                        <th>Student</th>
                        <td>
                            <table>
                                @foreach ( $data->allocatedseats as $allocatedseats  )
                                <tr>
                                        
                                    <td width="50%">@if ($allocatedseats->position ==1) 1.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }}@else 1. N/A @endif </td>
                                    <td>@if ($allocatedseats->position ==2) 2.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }}@else 2. N/A @endif </td>
                                    
                                </tr>
                                @if ($data->totalseats ==5)
                                <tr>
                                    <td>@if ($allocatedseats->position ==5)5.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }}@else 5. N/A @endif </td>
                                  </tr>
                                  @endif
                                <tr>
                                    <td>@if ($allocatedseats->position ==3) 3.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }}@else 3. N/A @endif </td>
                                    <td>@if ($allocatedseats->position ==4) 4.{{ $allocatedseats->students->name }} - {{ $allocatedseats->students->rollno }}@else 4. N/A @endif </4.>
                                </tr>
                                @endforeach
                              </table>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2">
                            <a href="{{ url('staff/rooms/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm"><i class="fa fa-edit"> Edit {{ $data->title }}  </i></a>
                        </td>
                        
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

