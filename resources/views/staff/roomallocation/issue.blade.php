@extends('staff/layout')
@section('title', 'Room Allocation Issue')

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
            <h3 class="m-0 font-weight-bold text-primary">Room Issue (Room Change/Leave)</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Student Name</th>
                            <th>Issue</th>
                            <th>Status</th>
                            <th>Assigned Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Student Name</th>
                            <th>Issue</th>
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
                                <a href="{{ route('staff.roomallocation.issueview',$d->id) }}" class="btn btn-info btn-sm" title="View Data"><i class="fa fa-eye"></i></a>
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

