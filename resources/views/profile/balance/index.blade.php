@extends('layout')
@section('title', 'Balance')

@section('content')


    <!-- Page Heading -->
    <div class="card-header p-1 my-1 bg-info">
        <h3 class="m-0 p-2 font-weight-bold text-white bg-info">
            My Balance  </h3>
    </div>

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
            <h6 class="m-0 font-weight-bold text-primary">Balance Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" >
                    @if ($data)
                    <tr>
                        <th>Student Name </th>
                        <td>{{ Auth::user()->name }}</td>
                    </tr><tr>
                        <th>Student Roll</th>
                        <td>{{ Auth::user()->rollno }}</td>
                    </tr><tr>
                        <th>Balance</th>
                        <td>{{ $data->balance_amount }} </td>
                    </tr><tr>
                        <th>Last Transaction Date </th>
                        <td>{{ $data->last_transaction_date }}</td>
                    </tr>
                    @else
                    <tr>
                        No History Available
                    </tr>
                    @endif
                        
                        
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection
@endsection

