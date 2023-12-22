@extends('layout')
@section('title', 'Meal Tokens')

@section('content')


    <!-- Page Heading -->
    <div class="card-header p-1 my-1 bg-info">
        <h3 class="m-0 p-2 font-weight-bold text-white bg-info">
            Meal Tokens </h3>
    </div>
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
            <h6 class="m-0 font-weight-bold text-primary">Meal Tokens Data
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>MealType</th>
                            <th>Orderno</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>MealType</th>
                            <th>Orderno</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->meal_type }}</td>
                            <td>{{ $d->order_id }}</td>
                            
                            @switch($d->status)
                                @case(1)
                                <td class="bg-success text-white"> Printed </td>
                                    @break
                                @case(2)
                                <td class="bg-warning text-white"> Error</td>
                                    @break
                                @case(3)
                                <td class="bg-info text-white"> On Queue To Print </td>
                                    @break
                                @default
                                <td class="bg-secondary text-white"> Not Used </td>
                            @endswitch
                                <td><a  href="{{ url('student/mealtoken/'.$d->order_id.'/show') }}" class="float-right btn btn-info btn-sm mx-1"><i class="fas fa-eye"> View</i></a>
                                    @if ($d->status==0 && $currentDateDash==$d->date)
                                    <a  href="{{ route('student.mealtoken.printnet',$d->order_id) }}" class="float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Print</i></a></td>
                                    @endif
                                    
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

