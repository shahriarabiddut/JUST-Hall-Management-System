@extends('admin/layout')
@section('title', 'History Details')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">History Details
                <a href="{{ route('admin.history.index') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> 
        </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Hall</th>
                        <th>{{ $data->hall->title }}</th>
                    </tr>
                    <tr>
                        <th>Staff</th>
                        <td>{{ $data->staff->name }}</td>
                    </tr>
                    <tr>
                        <th>Staff Email</th>
                        <td>{{ $data->staff->email }}</td>
                    </tr>
                    <tr>
                        <th>Details</th>
                        <td>{{ $data->data }}</td>
                    </tr>
                    <tr>
                        <th>Time of Action</th>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Time of Read</th>
                        <td>{{ $data->updated_at }}</td>
                    </tr>
                        </table>
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

