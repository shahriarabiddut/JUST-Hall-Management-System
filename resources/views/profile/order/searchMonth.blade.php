@extends('layout')
@section('title', 'Order History By Month')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Order History</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Money Spent This Month : {{ $sumofthatmonth }} Taka
                <div class="float-right">
                    <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.order.searchByMonth') }}">
                        @csrf
                        <label for="search-month">Search by Month:</label>
                        <input type="month" id="search-month" name="month" value="{{ $month }}">
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
                            <th>FoodName</th>
                            <th>Food Time</th>
                            <th>Order Time</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>FoodName</th>
                            <th>Food Time</th>
                            <th>Order Time</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @if ($d->food_item_id==0)
                                System Fixed Cost Charge
                                @else    
                                {{ $d->food->food_name }}
                                @endif
                                
                            </td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->order_type }}</td>
                            <td>{{ $d->quantity }}</td>
                            <td>{{ $d->price }}</td>
                            
                            
                            <td class="text-center">
                                <a href="{{ url('student/order/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye">View </i></a>
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

