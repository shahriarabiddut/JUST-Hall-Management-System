@extends('admin/layout')
@section('title', 'Department Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Department Details of {{ $data->title }}
            <a href="{{ url('admin/department') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr><tr>
                        <th>Detail</th>
                        <td>{{ $data->detail }}</td>
                    </tr><tr>
                        <td colspan="2">
                            <a href="{{ url('admin/department/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm"><i class="fa fa-edit"> Edit {{ $data->title }}  </i></a>
                        </td>
                        
                    </tr>
                   
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

