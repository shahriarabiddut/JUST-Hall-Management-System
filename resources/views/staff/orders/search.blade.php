@extends('staff/layout')
@section('title', 'Orders Search by date ')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders Search by date 
        <form method="POST"class="d-inline" action="{{ route('staff.orders.searchByDateDownload') }}">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <button type="submit" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-down"></i> Download Excel Sheet </button> 
      </form></h1>
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
            <h3 class="m-0 font-weight-bold text-primary">Order History
                <div class="float-right">
                    <form method="POST" class="form-control" action="{{ route('staff.orders.searchByDate') }}">
                        @csrf
                        <label for="search-date">Meal Type : </label>
                        <select  name="type" id="">
                            <option @if($type == 'x') selected @endif value="x">-- Select --</option>
                            @foreach ($dataFoodTime as $ft)
                            <option @if($type == $ft->title) selected @endif value="{{$ft->title}}">{{$ft->title}}</option>
                            @endforeach
                        </select>
                        <label for="search-date">Search History by Date : </label>
                        <input type="date" id="search-date" name="date" value="{{ $date }}">
                        <button type="submit">Search</button>
                      </form>
                </div>
                <a href="{{ url('staff/orders') }}" class="float-left mx-1 btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i></a>
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
                            <th>Order Time</th>
                            <th>Quantity</th>
                            <th>OrderNo</th>
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
                        </tr>
                    </tfoot> 
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @if ($d->student==null)
                                    User Deleted
                                @else
                                {{ $d->student->name }} - {{ $d->student->rollno }}
                                @endif
                                
                            </td>
                            <td>{{ $d->meal_type }}</td>
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

