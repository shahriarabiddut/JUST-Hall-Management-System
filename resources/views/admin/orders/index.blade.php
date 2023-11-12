@extends('admin/layout')
@section('title', 'Orders ')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders </h1>
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
            
            <div class="card shadow mb-4 pl-4 py-2 bg-secondary text-white">
                <form method="POST" action="{{ route('admin.orders.searchByHistory') }}">
                    @csrf
                    <label for="search-date">Search by Date with Details :</label>
                    <input type="date" id="search-date" name="date">
                    <button type="submit">Search</button>
                  </form>
            </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order History
                <div class="float-right">
                    <form method="POST" action="{{ route('admin.orders.searchByDate') }}">
                        @csrf
                        <label for="search-date">Search History by Date:</label>
                        <input type="date" id="search-date" name="date">
                        <button type="submit">Search</button>
                      </form>
                </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>FoodTime</th>
                            <th>FoodName</th>
                            <th>Order Time</th>
                            <th>Quantity</th>
                            <th>OrderNo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>FoodTime</th>
                            <th>FoodName</th>
                            <th>Order Time</th>
                            <th>Quantity</th>
                            <th>OrderNo</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            @php
                                $i=$key;
                            @endphp
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->student->name }} - {{ $d->student->rollno }}</td>
                            <td>{{ $d->order_type }}</td>
                            <td>{{ $d->food->food_name }}</td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->quantity }}</td>
                            <td>{{ $d->id }}</td>
                            <td>
                                <a  href="{{ url('admin/orders/status/'.$d->id) }}" class="m-1 float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Token</i></a>
                                @if ($token[$i]==1)
                                <p class="float-right btn btn-danger btn-sm m-1"><i class="fas fa-ticket-alt"> Used</i></p>
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

