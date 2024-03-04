@extends('admin/layout')
@section('title', 'Orders ')

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
                <form onsubmit="handleSubmit(event)"  method="POST" class="p-1" action="{{ route('admin.orders.searchByDate') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md mt-1"> <button class="form-control btn btn-dark" type="reset">Search by Date :</button> </div>
                        <div class="col-md mt-1">
                        <select class="form-control" required name="hall_id" id="">
                            <option value="0">-- Select Hall--</option>
                            @foreach ($halls as $ft)
                            <option value="{{$ft->id}}">{{$ft->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md mt-1">
                    <select class="form-control" name="type" id="">
                        <option value="x">-- Select Meal Type--</option>
                        @foreach ($dataFoodTime as $ft)
                        <option value="{{$ft->title}}">{{$ft->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md mt-1">
                    <input class="form-control"  required type="date" id="search-date" name="date">
                </div>
                <div class="col-md mt-1">
                    <button class="form-control btn btn-info"  type="submit">Search</button>
                </div>
            </div>
                  </form>
            </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">All Orders
                <div class="float-right h6">
                    <form onsubmit="handleSubmit(event)"  method="POST" class="p-1 " action="{{ route('admin.orders.searchByHistory') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-3 mt-1">
                        <button class="form-control btn btn-dark p-1" type="reset"> Order History </button>
                    </div>
                    <div class="col-md-3 mt-1">
                        <select class="form-control" required name="hall_id" id="">
                            <option value="0">-- Select Hall --</option>
                            @foreach ($halls as $ft)
                            <option value="{{$ft->id}}">{{$ft->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mt-1">
                        <input  class="form-control" required type="date" id="search-date" name="date">
                    </div>
                    <div class="col-md-3 mt-1">
                        <button class="form-control btn btn-info" type="submit">Search</button>
                    </div>
                    </div>
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
                            <td>
                                @if ($d->student==null)
                                    User Deleted
                                @else
                                    {{ $d->student->name }} - {{ $d->student->rollno }}  
                                @endif
                                @if ($d->hall!=null)
                                [{{ $d->hall->title }}]
                                @endif
                                
                            </td>
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

