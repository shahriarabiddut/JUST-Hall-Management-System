@extends('admin/layout')
@section('title', 'Room Allocation Issues')

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
            <h3 class="m-0 font-weight-bold text-primary">Room Issue (Room Change/Leave) Requests</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room</th>
                            <th>Student</th>
                            <th>Hall</th>
                            <th>Issue</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Room</th>
                            <th>Student</th>
                            <th>Hall</th>
                            <th>Issue</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @php $i=1; @endphp
                        @foreach ($data as $key=> $d)
                        <tr>
                            <td>{{ $i++ }} @if ($d->flag==0)<span class="bg-danger text-white p-1 rounded"> New </span>@endif</td>
                            <td>
                                @if ($d->students->allocatedRoom->rooms==null)
                                    Room Deleted
                                @else
                                    {{ $d->students->allocatedRoom->rooms->title }} (Seat No. {{ $d->students->allocatedRoom->position }})
                                @endif
                            </td>
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
                            <td>
                                @if ($d->students==null)
                                    User Deleted
                                @else
                                {{ $d->students->hall->title }}
                                @endif
                            </td>
                            <td>
                                @if ($d->issue=='roomchange')
                                    Room Change
                                @else
                                    Leave Room
                                @endif
                            </td>
                            <td   @switch($d->status)
                                @case(1)
                                 class="bg-success text-white"> Accepted
                                    @break
                                @case(1)
                                class="bg-danger text-white"> Rjected
                                    @break
                                @default
                                class="bg-info text-white">
                                    No Reply
                            @endswitch
                            </td>
                            
                            <td>{{ $d->created_at->format("F j, Y") }} </td>

                            <td class="text-center">
                                <a href="{{ route('admin.roomallocation.issueview',$d->id) }}" class="btn btn-info btn-sm" title="View Data"><i class="fa fa-eye"></i></a>
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

