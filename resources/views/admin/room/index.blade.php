@extends('admin/layout')
@section('title', 'Rooms')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rooms</h1>
    <p class="mb-4">Room</p>
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
            <h6 class="m-0 font-weight-bold text-primary">Room Data
            <a href="{{ route('admin.rooms.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>RoomType</th>
                            <th>Total Seats</th>
                            <th>Allocated Seats</th>
                            <th>Vacancy</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>RoomType</th>
                            <th>Total Seats</th>
                            <th>Allocated Seats</th>
                            <th>Vacancy</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->roomtype->title }}</td>
                            <td>{{ $d->totalseats }}</td>
                            <td>{{ count($d->allocatedseats) }}</td>
                            @if ($d->vacancy==0)
                            <td class="bg-success"> Room Full </td>
                            @else
                            <td>{{ $d->vacancy }}</td>
                            @endif
                            
                            <td class="text-center">
                                <a href="{{ url('admin/rooms/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                <a href="{{ url('admin/rooms/'.$d->id.'/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/rooms/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

