@extends('admin/layout')
@section('title', 'Room Allocation Requests')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Room Allocation Requests</h1>
    <p class="mb-4">Room Allocation</p>
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
            @if(Session::has('warning'))
            <div class="p-3 mb-2 bg-warning text-white">
                <p>{{ session('warning') }} </p>
            </div>
            @endif
            <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Allocation Requests Data
            <a href="{{ route('admin.roomallocation.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New Room Allocation</a> </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Student Name</th>
                            <th>Student Roll</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Student Name</th>
                            <th>Student Roll</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key=> $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->rooms->title }}</td>
                            <td>{{ $d->students->name }}</td>
                            <td>{{ $d->students->rollno }}</td>
                            <td>{{ $d->created_at }}</td>
                            @if ($d->status=='1')
                            <td class="bg-success"> Accepted </td>
                            @elseif($d->status=='0')
                            <td class="bg-warning"> On Queue </td>
                            @elseif($d->status=='2')
                            <td class="bg-danger"> Rejected </td>
                            @else
                            <td>Requested </td>
                            @endif

                            <td class="text-center">

                                <a  title="View Request" href="{{ url('admin/roomallocation/roomrequests/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                @if ($d->status!='2')
                                <a title="Reject" onclick="return confirm('Are You Sure?')" href="{{ url('admin/roomallocation/ban/'.$d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                @endif
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

