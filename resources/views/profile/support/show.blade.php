@extends('layout')
@section('title', 'Support Ticket Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Support Ticket Details of <span class="bg-warning">-- {{ $data->subject }} -- </span> 
            <a href="{{ url('student/support') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Ticket No</th>
                        <td>{{ $data->id }}</td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{ $data->subject }}</td>
                    </tr><tr>
                        <th>Details</th>
                        <td>{{ $data->message }}</td>
                    </tr>
                    <tr>
                        <th>Reply</th>
                        <td>
                            @if($data->reply)
                            {{ $data->reply }}
                            @else
                            No Reply Yet!
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ticket Creation Date</th>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                   
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

