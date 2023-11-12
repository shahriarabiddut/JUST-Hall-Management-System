@extends('staff/layout')
@section('title', 'Mealtoken Details')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"> Mealtoken Details </h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Mealtoken Details 
            <a href="{{ url('staff/orders') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body bg-danger text-white p-2">
            <h1 class="text-center font-weight-bold"> Meal Token Allready Used</h1>
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
                            @case(0)
                               <td class="bg-success text-white"> Not Used </td>
                                   @break
                            @case(1)
                            <td class="bg-danger text-white"> Used </td>
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
                    @if($data->status==0)
                        <td colspan="2">
                                    <a href="{{ route('staff.orders.valid',$data->id) }}" class="float-right btn btn-info btn-sm btn-block p-2"><i class="fas fa-ticket-alt"> Mark as Used </i></a> 
                        </td>                            
                    @endif
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

