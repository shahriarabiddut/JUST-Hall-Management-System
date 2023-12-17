@extends('layout')
@section('title', 'Support Tickets')

@section('content')


    <!-- Page Heading -->
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
            <h3 class="m-0 font-weight-bold text-primary">Support Tickets Data
            <a href="{{ route('student.support.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->subject }}</td>
                            <td>{{ $d->category }}</td>
                            
                                @switch($d->status)
                                    @case('2')
                                    <td class="bg-warning text-white"> On Process</td>
                                        @break
                                    @case('1')
                                    <td class="bg-success text-white"> Solved</td>
                                        @break
                                    @default
                                    <td>  No Reply</td>
                                @endswitch
                            
                            
                            <td class="text-center">
                                <a href="{{ url('student/support/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                @if ($d->status==null || $d->status==0)
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('student/support/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>@endif
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

