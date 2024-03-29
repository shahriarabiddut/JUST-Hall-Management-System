@extends('staff/layout')
@section('title', 'Orders ')

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
            
            <div class="card shadow mb-1 p-1 bg-secondary text-white">
                <form method="POST" class=" p-1 m-1" action="{{ route('staff.orders.searchByHistory') }}">
                    @csrf
                    <label for="search-date">Search by Date with Details :</label>
                    <input type="date" id="search-date" name="date">
                    <button type="submit">Search</button>
                  </form>
            </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary d-inline" >Order History</h3>
                <div class="float-right">
                    <form method="POST" class="form-control p-1" action="{{ route('staff.orders.searchByDate') }}">
                        @csrf
                        <label for="search-date">Meal Type : </label>
                        <select  name="type" id="">
                            <option value="x">-- Select --</option>
                            @foreach ($dataFoodTime as $ft)
                            <option value="{{$ft->title}}">{{$ft->title}}</option>
                            @endforeach
                        </select>
                        <label for="search-date">Search History by Date : </label>
                        <input type="date" id="search-date" name="date" >
                        <button type="submit">Search</button>
                    </form>
                </div>
            </h3>
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
                            <th>Meal Date</th>
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
                            <th>Meal Date</th>
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
                            <td>
                                @if ($d->student==null)
                                    User Deleted
                                @else
                                {{ $d->student->name }} - {{ $d->student->rollno }}
                                @endif
                            </td>
                            <td>{{ $d->order_type }}</td>
                            <td>
                                @if ($d->food==null)
                                    Food Item Deleted
                                @else
                                    {{ $d->food->food_name }}
                                @endif
                            </td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->quantity }}</td>
                            <td>{{ $d->id }}</td>
                            <td>
                                <a  href="{{ url('staff/orders/status/'.$d->id) }}" class="m-1 float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Token</i></a>
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

