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
            
            <div class="card shadow mb-4 pl-4 py-2 bg-secondary text-white">
                <form onsubmit="handleSubmit(event)"  method="POST" class="p-1" action="{{ route('staff.orders.searchByDate') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-3 mt-1"> <button class="form-control btn btn-dark" type="reset">Search by Date :</button> </div>
                    <div class="col-md-3 mt-1">
                    <select class="form-control" name="type" id="">
                        <option value="x">-- All Meal Type--</option>
                        @foreach ($dataFoodTime as $ft)
                        <option value="{{$ft->title}}">{{$ft->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-1">
                    <input class="form-control"  required type="date" id="search-date" name="date">
                </div>
                <div class="col-md-3 mt-1">
                    <button class="form-control btn btn-info"  type="submit">Search</button>
                </div>
            </div>
                  </form>
            </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary d-inline" >All Orders</h3>
                <div class="float-right h6">
                    <form onsubmit="handleSubmit(event)"  method="POST" class="p-1 " action="{{ route('staff.orders.searchByHistory') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4 mt-1">
                        <button class="form-control btn btn-dark p-1" type="reset"> Order History </button>
                    </div>
                    <div class="col-md-4 mt-1">
                        <input  class="form-control" required type="date" id="search-date" name="date">
                    </div>
                    <div class="col-md-4 mt-1">
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
                        @php $i=1; @endphp
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ $i++ }}</td>
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
                                @if ($d->token!=null)
                                <a  href="{{ url('staff/orders/status/'.$d->id) }}" class="m-1 float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Token</i></a>
                                @if ($d->token->status==1)
                                <p class="float-right btn btn-danger btn-sm m-1"><i class="fas fa-ticket-alt"> Used</i></p>
                                @endif
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

