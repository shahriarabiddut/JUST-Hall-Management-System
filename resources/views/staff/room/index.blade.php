@extends('staff/layout')
@section('title', 'Rooms')
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
            @if(Session::has('danger-titles'))
            <div class="p-3 mb-2 bg-danger text-white">
                <h3>Allready Existed Room's</h3>
                @foreach (session('danger-titles') as $etitles)
                    <span class="m-1">
                        {{ $etitles }} ,
                    </span>
                     @endforeach
            </div>
            @endif
            <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Data
                <a href="{{ route('staff.rooms.create') }}" class="float-right btn btn-success btn-sm mx-2">Add New </a>  
                <a href="{{ route('staff.rooms.bulk') }}" class="float-right btn btn-info btn-sm" target="_blank">Add From CSV </a>  </h3>
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
                            <td>
                                
                            @if ($d->roomtype!=null)
                            {{ $d->roomtype->title }}
                            @else
                            {{ $d->room_type_id }}
                            @endif
                            </td>
                            <td>{{ $d->totalseats }}</td>
                            <td>{{ count($d->allocatedseats) }}</td>
                            @if ($d->vacancy==0)
                            <td class="bg-success"> Room Full </td>
                            @else
                            <td>{{ $d->vacancy }}</td>
                            @endif
                            
                            <td class="text-center">
                                <a href="{{ url('staff/rooms/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                <a href="{{ url('staff/rooms/'.$d->id.'/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/rooms/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

