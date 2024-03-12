@extends('staff/layout')
@section('title', 'Room Allocation Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Allocation Details of @if ($data->students==null)
                                    User Deleted
                                @else
                                    {{ $data->students->name }} - {{ $data->students->rollno }}
                                @endif
            <a href="{{ url('staff/roomallocation') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <th> Room No </th>
                            <td>
                                @if ($data->rooms==null)
                                    Room Deleted
                                @else
                                    {{ $data->rooms->title }}
                                @endif
                                </td>
                             </tr>
                        <tr><tr>
                            <th>Seat No </th>
                            <td>{{ $data->position }}</td>
                        </tr>
                            <th>Student </th>
                            <td>
                                @if ($data->students==null)
                                    User Deleted
                                @else
                                    {{ $data->students->name }} - {{ $data->students->rollno }}
                                @endif
                            </td>
                        </tr><tr>
                            <th>Allocation Date </th>
                            <td>{{ $data->created_at->format("F j, Y H:i:s") }} </td>
                        </tr>
                        @if ($data->status==0)
                        <tr>
                            <th>Allocation Remove Date </th>
                            <td>{{ $data->updated_at->format("F j, Y H:i:s") }} </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2">
                                @if ($data->status==1)
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/roomallocation/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm" title="Remove Data"><i class="fa fa-ban"> Remove Room Allocation </i></a>
                                <a href="{{ url('staff/roomallocation/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm" title="Edit Data"> <i class="fa fa-edit"> Edit </i></a> 
                                @else
                                <a href="{{ url('staff/roomallocation/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm" title="Edit Data"> <i class="fa fa-edit"> Reallocate Room </i></a> 
                                @endif
                            </td>
                            
                        </tr>
                        
                </table>
                @php $report = json_decode($data->report, true); $j=1;@endphp
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th class="text-center h-4 bg-secondary text-white"> Report </th>
                    <tr>
                    @foreach ($report as $r) <tr><td> {{ $j++ }} . {{ $r }}</td> </tr> @endforeach
            </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

