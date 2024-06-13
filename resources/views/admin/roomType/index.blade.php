@extends('admin/layout')
@section('title', 'Room Types')

@section('content')

            <!-- Session Messages Starts -->
            @if(Session::has('success'))
            <div class="p-3 mb-2 bg-success text-white">
                <p>{{ session('success') }} </p>
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="p-3 mb-2 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
            @endif
            <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Type 
            <a href="{{ route('admin.roomtype.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New Type</a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Images</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Images</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key=> $d)
                            
                        
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->details }}</td>
                            <td>{{ $d->price }}</td>
                            <td>{{ count($d->roomtypeimages) }}</td>
                            
                            <td class="text-center">
                                <a href="{{ url('admin/roomtype/'.$d->id) }}" class="btn btn-info btn-sm" title="View Data"><i class="fa fa-eye"></i></a>
                                <a href="{{ url('admin/roomtype/'.$d->id.'/edit') }}" class="btn btn-primary btn-sm" title="Edit Data"> <i class="fa fa-edit"></i></a>
                                {{-- <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/roomtype/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm" title="Remove Data"><i class="fa fa-trash"></i></a> --}}
                            </td>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

