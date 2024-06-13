@extends('staff/layout')
@section('title', 'Food Item')

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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Food Item
            <a href="{{ route('staff.food.create') }}" class="float-right btn btn-success btn-sm">Add New</a> </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Food Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Food Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @php $i =0; @endphp
                        @foreach ($data as $d)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $d->food_name }}</td>
                            <td>{{ $d->price }} /= Taka</td>
                            @switch($d->foodtime->title)
                            @case('Lunch')
                                <td class="bg-warning text-white text-center"> {{ $d->foodtime->title }} <i class="fas fa-sun"></i></td>
                                    @break
                            @case('Dinner')
                            <td class="bg-info text-white text-center"> {{ $d->foodtime->title }} <i class="fas fa-star"></i></td>
                                @break
                            @case('Suhr')
                            <td class="bg-dark text-white text-center"> {{ $d->foodtime->title }} <i class="fas fa-moon"></i></td>
                                @break
                            @endswitch
                                 
                            @switch($d->status)
                            @case(0)
                                <td class="bg-danger text-white text-center"> Disable</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white text-center"> Active</td>
                                @break
                            @endswitch
                            
                            <td class="text-center">
                                <a href="{{ url('staff/food/'.$d->id) }}" class="btn btn-info btn-sm m-1" title="View Data"><i class="fa fa-eye">View </i></a>
                                @switch($d->status)
                                @case(1)
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/food/'.$d->id.'/disable') }}" class="btn btn-danger btn-sm m-1"><i class="fa fa-ban">Disable</i></a>
                                        @break
                                @case(0)
                                <a href="{{ url('staff/food/'.$d->id.'/active') }}" class="btn btn-success btn-sm m-1"><i class="fa fa-check">Active</i></a>
                                    @break
                                @endswitch
                                
                                
                                
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

