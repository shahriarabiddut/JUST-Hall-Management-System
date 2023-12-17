@extends('layout')
@section('title', 'Order Details')
@section('content')


    <!-- Page Heading -->
    <div class="card-header p-1 my-1 bg-info">
        <h3 class="m-0 p-2 font-weight-bold text-white bg-info">
            Order Data </h3>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Order Details 
            <a href="{{ url('student/order') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
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
                    @if ($validDate=='true')
                    <tr>
                        <td colspan="2">
                            <a  href="{{ route('student.order.delete',$data->id) }}" class="float-right mx-1 btn btn-danger btn-sm "><i class="fas fa-ban"> Cancel Order </i></a>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

