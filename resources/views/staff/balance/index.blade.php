@extends('staff/layout')
@section('title', 'Balance')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Balance History</h1>
    <p class="mb-4">Balance of students</p>
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
            <h6 class="m-0 font-weight-bold text-primary">Balance Data
            <a href="{{-- route('admin.balance.create') --}}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Balance</th>
                            <th>Last Transaction Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Balance</th>
                            <th>Last Transaction Date</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->students->name }} - {{ $d->students->rollno }}</td>
                            @if ($d->balance_amount<0)
                            <td class="bg-danger text-white">
                            @else
                            <td class="bg-success text-white">
                            @endif
                            {{ $d->balance_amount }}</td>
                            <td>{{ $d->last_transaction_date }}</td>
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

