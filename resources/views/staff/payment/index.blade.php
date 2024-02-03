@extends('staff/layout')
@section('title', 'Payments')

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
            <h3 class="m-0 font-weight-bold text-primary">Payments 
            <a href="{{ route('staff.payment.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->students->name }} - {{ $d->students->rollno }}</td>
                            <td>{{ $d->amount }}</td>
                            <td>{{ $d->created_at }}</td>
                            
                            @switch($d->status)
                                @case('Processing')
                                   <td class="bg-warning text-white"> Processing</td>
                                       @break
                                @case('Completed')
                                <td class="bg-warning text-white"> Completed</td>
                                    @break
                                @case('Accepted')
                                <td class="bg-success text-white"> Accepted by {{ $d->staff->name }}</td>
                                    @break
                                @case('Rejected')
                                <td class="bg-danger text-white"> Rejected by {{ $d->staff->name }}</td>
                                    @break
                                @default
                                   <td>{{$d->status}}</td>
                            @endswitch
                            
                            <td class="text-center">
                                <a href="{{ url('staff/payment/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                @if($d->status == 'Accepted' || $d->status == 'Rejected')
                                @else
                                <a href="{{ url('staff/payment/'.$d->id.'/accept') }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/payment/'.$d->id.'/reject') }}" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i></a>
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

