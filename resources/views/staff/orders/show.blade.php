@extends('staff/layout')
@section('title', 'Mealtoken Details')
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Mealtoken Details 
            <a href="{{ url('staff/orders') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body {{ $bg }} text-white p-2">
            <h1 class="text-center font-weight-bold"> {{ $messageExtra }}</h1>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th width="60%">Meal Type</th>
                        <td width="40%">{{ $data->meal_type }}</td>
                    </tr>
                    <tr>
                        <th>Meal</th>
                        <td>{{ $data->food_name }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $data->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Printed Date</th>
                        <td>
                            @if ($data->created_at==$data->updated_at)
                                Not Printed Yet
                            @else
                                {{ $data->updated_at }}
                            @endif
                            </td>
                        
                        
                    </tr>
                    <tr>
                        <th>Status</th>
                        @switch($data->status)
                            @case(3)
                               <td class="bg-info text-white"> Token On Print Queue </td>
                                   @break
                            @case(1)
                            <td class="bg-danger text-white"> Used</td>
                                @break
                            @case(2)
                            <td class="bg-warning text-white"> Error</td>
                                @break
                            @default
                            <td class="bg-success text-white"> Not Used </td>
                        @endswitch
                    </tr>
                    
                    
                    <tr>
                        <th>Order No</th>
                        <td>{{ $data->order_id }}</td>
                    </tr>
                    <tr>
                        <th>Token No</th>
                        <td>{{ $data->id }}</td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="2" class="m-1">
                            <a href="{{ route('staff.orders.printToken',$data->order_id) }}" class="float-right btn btn-success btn-sm btn-block p-2"><i class="fas fa-ticket-alt"> Print </i></a>           
                            @if($data->status!=1)
                            <a href="{{ route('staff.orders.valid',$data->id) }}" class="float-right btn btn-info btn-sm btn-block p-2"><i class="fas fa-ticket-alt"> Mark as Used </i></a> 
                            @endif
                        </td>                            
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

