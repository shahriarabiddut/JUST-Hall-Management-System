@extends('admin/layout')
@section('title', 'Orders Search by date ')

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
            <div class="card shadow mb-4 pl-4 py-2 bg-secondary text-white">
                <form method="POST" class="p-1" action="{{ route('admin.orders.searchByDate') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-3 mt-1">
                        <select class="form-control" required name="hall_id" id="">
                            <option value="0">-- Select Hall--</option>
                            @foreach ($halls as $ft)
                            <option @if($hall_id == $ft->id) selected @endif value="{{$ft->id}}">{{$ft->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mt-1">
                        <select class="form-control"  name="type" id="">
                            <option @if($type == 'x') selected @endif value="x">-- Select Meal Type --</option>
                            @foreach ($dataFoodTime as $ft)
                            <option @if($type == $ft->title) selected @endif value="{{$ft->title}}">{{$ft->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mt-1">
                        <input class="form-control"  type="date" id="search-date" name="date" value="{{ $date }}">
                    </div>
                    <div class="col-md-3 mt-1">
                    <button class="form-control btn btn-info" type="submit">Search</button>
                </div>
                    </div>
                  </form>
            </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                <div class="float-left">
                    <h3 class="m-0 font-weight-bold text-primary"> Order History : 
                    
                </div>
            <h6 class="m-0 font-weight-bold text-primary"><a href="{{ route('admin.orders.index') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> All Orders</a> </h6>

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
                            <td>{{ $d->student->name }} - {{ $d->student->rollno }}</td>
                            <td>{{ $d->order_type }}</td>
                            <td>{{ $d->food->food_name }}</td>
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

