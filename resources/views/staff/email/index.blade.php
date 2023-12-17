@extends('staff/layout')
@section('title', 'Emails')

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
            <h3 class="m-0 font-weight-bold text-primary">Email 
            <a href="{{ route('staff.email.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Send New Email</a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Objective</th>
                            <th>Sent Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Objective</th>
                            <th>Sent Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key=> $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->subject }}</td>
                            <td>{{ $d->objective }}</td>
                            <td>{{ $d->created_at }}</td>
                            
                            <td class="text-center">
                                <a href="{{ url('staff/email/'.$d->id) }}" class="btn btn-info btn-sm mb-1"><i class="fa fa-eye"></i></a> <br> 
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/email/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

