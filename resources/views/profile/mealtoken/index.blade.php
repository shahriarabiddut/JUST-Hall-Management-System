@extends('layout')
@section('title', 'Meal Tokens')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Meal Tokens</h1>
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
                            <th>Student</th>
                            <th>MealType</th>
                            <th>Orderno</th>
                            <th>Creation Time</th>
                            <th>Print Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>MealType</th>
                            <th>Orderno</th>
                            <th>Creation Time</th>
                            <th>Print/Error Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ Auth::user()->name }}</td>
                            <td>{{ $d->meal_type }}</td>
                            <td>{{ $d->order_id }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>
                                @if ($d->created_at==$d->updated_at)
                                    Not Printed Yet
                                @else
                                    {{ $d->updated_at }}
                                @endif
                                </td>
                            
                            @switch($d->status)
                                @case(0)
                                <td class="bg-success text-white"> Not Used </td>
                                    @break
                                @case(1)
                                <td class="bg-danger text-white"> Printed </td>
                                    @break
                                @case(2)
                                <td class="bg-warning text-white"> Error</td>
                                    @break
                                @default
                                <td class="bg-success text-white"> Not Used </td>
                            @endswitch
                                <td><a  href="{{ url('student/mealtoken/'.$d->order_id.'/show') }}" class="float-right btn btn-info btn-sm m-1"><i class="fas fa-eye"> View</i></a>
                                    @if ($d->status!=1)
                                    <a  href="{{ url('student/mealtoken/print/'.$d->id) }}" class="float-right btn btn-success btn-sm "><i class="fas fa-ticket-alt"> Print</i></a></td>
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

