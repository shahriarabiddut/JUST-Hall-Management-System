@extends('admin/layout')
@section('title', 'Email Details')
@section('content')


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Email Details of {{ $data->title }} 
            <a href="{{ url('admin/email') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                        
                        <tr>
                        <th>Email </th>
                             <td>{{ $data->email }}</td>
                         </tr><tr>
                       <th>Name </th>
                            <td>{{ $data->name }}</td>
                        </tr><tr>
                        <th>Subject </th>
                                <td>{{ $data->subject }}</td>
                        </tr><tr>
                        <th>Objective </th>
                                <td>{{ $data->objective }}</td>
                        </tr><tr>
                        <tr>
                        <th>Message </th>
                                <td>{{ $data->message }}</td>
                        </tr><tr>
                        <th>Sent Date </th>
                                <td>{{ $data->created_at }}</td>
                            </tr>
                            
                        </tr>
                        
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

