@extends('layout')
@section('title', 'Mealtoken Details')
@section('content')


    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Mealtoken Details 
            <a href="{{ url('student/mealtoken') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h2>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th width="60%">Date</th>
                        <td width="40%">{{ $data->order->date }}</td>
                    </tr>
                    <tr>
                        <th>Meal Type</th>
                        <td >{{ $data->order->order_type }}</td>
                    </tr>
                    <tr>
                        <th>Meal</th>
                        <td>{{ $data->food_name }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $data->order->quantity }}</td>
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
                            
                            @case(1)
                            <td class="bg-danger text-white"> Used </td>
                                @break
                            @case(2)
                            <td class="bg-warning text-white"> Error</td>
                                @break
                            @case(3)
                            <td class="bg-info text-white"> On Queue To Print </td>
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
                        <th>QR Code</th>
                        <td>{!! QrCode::size(300)->generate($data->token_number) !!}</td>
                    </tr>
                    
                    <tr>
                        @if ($data->status==0 && $currentDateDash==$data->date)
                        <td colspan="2">
                            {{-- <a  href="{{ url('student/mealtoken/print/'.$data->id) }}" class="m-1 float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Print Meal Token </i></a> --}}
                            <a  href="{{ route('student.mealtoken.printnet',$data->order_id) }}" class="m-1 float-left btn btn-info btn-sm "><i class="fas fa-ticket-alt"> Print Meal Token Net </i></a>
                        </td>
                        @endif
                        
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    <style>
        svg {
        height: 150px!important;
        }
    </style>
    @endsection
@endsection

