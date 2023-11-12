@extends('layout')
@section('title', 'Payments')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Payments</h1>
    <p class="mb-4">Payments</p>
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
            <h6 class="m-0 font-weight-bold text-primary">Payments Data
            <a href="{{ route('student.payments.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Creation Date</th>
                            <th>Status</th>
                            <th>Accepted/Rejection Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Creation Date</th>
                            <th>Status</th>
                            <th>Accepted/Rejection Date</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ Auth::user()->name }}</td>
                            <td>{{ $d->payment_method }}
                                @switch($d->payment_method)
                                @case('cash')
                                   
                                       @break
                                @default
                                    -TRXID {{ $d->transid }}
                            @endswitch
                            </td>
                            <td>{{ $d->amount }}</td>
                            <td>{{ $d->created_at }}</td>
                            
                            @switch($d->status)
                                @case(0)
                                   <td class="bg-warning text-white"> Checking</td>
                                       @break
                                @case(1)
                                <td class="bg-success text-white"> Accepted by {{ $d->staff->name }}</td>
                                    @break
                                @case(2)
                                <td class="bg-danger text-white"> Rejected by {{ $d->staff->name }}</td>
                                    @break
                                @default
                                   <td>   No Action Taken </td>
                            @endswitch
                            <td>{{ $d->updated_at }}</td>

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

