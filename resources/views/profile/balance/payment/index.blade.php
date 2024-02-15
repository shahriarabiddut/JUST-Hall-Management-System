@extends('layout')
@section('title', 'Payments')

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
            <h3 class="m-0 font-weight-bold text-primary">Payments Data
            <a href="{{ route('student.payments.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Creation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Creation Date</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->students->name }}</td>
                            <td>{{ $d->amount }}</td>
                            <td>@if ($d->created_at==null)
                                N/A
                            @else
                            {{ $d->created_at->format('F j, Y - H:i:s') }}
                            @endif
                                </td>
                            
                            @switch($d->status)
                                @case('Pending')
                                   <td class="bg-warning text-white"> Pending</td>
                                       @break
                                @default
                                   <td>   {{ $d->status }} </td>
                            @endswitch

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

