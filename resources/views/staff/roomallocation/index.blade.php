@extends('staff/layout')
@section('title', 'Room Allocation')

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
                <h3>Allready Existed Allocation's</h3>
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
            <h3 class="m-0 font-weight-bold text-primary">Room Allocation
            <a href="{{ route('staff.roomallocation.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New Room Allocation</a> <a href="{{ route('staff.roomallocation.bulk') }}" class="float-right btn btn-info btn-sm mx-2" target="_blank">Add From CSV </a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Seat No</th>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Assigned Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Seat No</th>
                            <th>Student Name</th>
                            <th>Status</th>
                            <th>Assigned Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @php $i=1; @endphp
                        @foreach ($data as $key=> $d)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                @if ($d->rooms==null)
                                    Room Deleted
                                @else
                                    {{ $d->rooms->title }}
                                @endif
                                </td>
                            <td>{{ $d->position }}</td>
                            <td>
                                @if ($d->students==null)
                                    User Deleted
                                @else
                                {{ $d->students->name }} - {{ $d->students->rollno }}
                                <!--@if($d->students->gender)-->
                                <!-- -Man @else - Female-->
                                <!--@endif-->
                                @endif
                            </td>
                            @if ($d->status==0)
                            <td class="bg-danger text-white">
                                    Removed
                                @else
                            <td class="bg-success text-white">
                                    Active
                                @endif
                            </td>
                            <td>{{ $d->created_at->format("F j, Y") }} </td>

                            <td class="text-center">
                                <a href="{{ url('staff/roomallocation/'.$d->id) }}" class="btn btn-info btn-sm" title="View Data"><i class="fa fa-eye"></i></a>
                                {{-- <a href="{{ url('staff/roomallocation/'.$d->id.'/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> --}}
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/roomallocation/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm" title="Remove Data"><i class="fa fa-trash"></i></a>
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

