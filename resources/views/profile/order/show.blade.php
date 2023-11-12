@extends('layout')
@section('title', 'Order Details')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"> Order Details </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order Details 
            <a href="{{ url('student/order') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Order Type</th>
                        <td>{{ $data->order_type }}</td>
                    </tr>
                    <tr>
                        <th>Meal</th>
                        <td>{{ $data->food->food_name }}</td>
                    </tr>
                    <tr>
                        <th>Meal Ordered Date</th>
                        <td>{{ $data->date }}</td>
                    </tr>
                    <tr>
                        <th>Order Time</th>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $data->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ $data->price }}</td>
                    </tr>
                    <tr>
                        <th>Order No</th>
                        <td>{{ $data->id }}</td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            @if (isset($tokendata))
                            <a  href="{{ route('student.mealtoken.showbyorder',$data->id) }}" class="float-right m-1 btn btn-primary btn-sm "><i class="fas fa-eye"> View Meal Token </i></a>
                            <a  href="{{ route('student.mealtoken.printnet',$data->id) }}" class="float-right m-1 btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Print Meal Token </i></a>
                            @else
                            <a  href="{{ url('student/mealtoken/generate/'.$data->id) }}" class="float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Generate Meal Token </i></a>
                            @endif
                            <a href="{{ route('student.order.edit',$data->id) }}" class="float-left btn btn-info btn-sm mr-1"><i class="fa fa-edit"> Edit {{ $data->title }}  </i></a> 
                            
                        </td>
                        
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a  href="{{ route('student.order.delete',$data->id) }}" class="float-right mx-1 btn btn-danger btn-sm "><i class="fas fa-ban"> Cancel Order </i></a>
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

