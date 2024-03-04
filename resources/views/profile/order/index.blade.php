@extends('layout')
@section('title', 'Order ')

@section('content')

<div class="card-header p-1 my-1 bg-info">
    <h3 class="m-0 p-2 font-weight-bold text-white bg-info">
        Order </h3>
</div>
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
    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-sm">
                    <h6 class="m-0 font-weight-bold text-primary">Order History </h6>
                </div>
                <div class="col-sm float-right">
                    <select id="mySelect" class="m-1" class="float-left form-control">
                        <option value="option"> Search By Date/ Month </option>
                        <option value="option2"> Search By Month </option>
                        <option value="option1"> Search By Date </option>
                      </select>
                </div>
                <div class="col-6 float-right">
                    <div id="myDiv" style="display: none;" >
                        <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.order.searchByDate') }}">
                            @csrf
                            <label for="search-date">Search by Date:</label>
                            <input type="date" id="search-date" name="date">
                            <button type="submit">Search</button>
                          </form>
                      </div>
                      <div id="myDiv2" style="display: none;">
                        <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.order.searchByMonth') }}">
                            @csrf
                            <label for="search-month">Search by Month:</label>
                            <input type="month" id="search-month" name="month">
                            <button type="submit">Search</button>
                        </form>
                      </div>
                </div>
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
                            <td>{{ $d->food->food_name }}</td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->order_type }}</td>
                            <td>{{ $d->quantity }}</td>
                            <td>৳ {{ $d->price }} /=</td>
                            
                            
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
    <script>
        const select = document.getElementById('mySelect');
        const div = document.getElementById('myDiv');
        const div2 = document.getElementById('myDiv2');

        select.addEventListener('change', (event) => {
        if (event.target.value === 'option1') {
            div.style.display = 'block';
            div2.style.display = 'none';
        }else if (event.target.value === 'option2') {
            div2.style.display = 'block';
            div.style.display = 'none';
        } else {
            div.style.display = 'none';
        }
        });

    </script>
    @endsection
@endsection

