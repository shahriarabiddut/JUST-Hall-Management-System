@extends('staff/layout')
@section('title', 'FoodTime')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">FoodTime</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">FoodTime Data
            <a href="{{ route('staff.foodtime.create') }}" class="float-right btn btn-success btn-sm" target="_blank">Add New</a> </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Detail</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Detail</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                        @foreach ($data as $key => $d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->detail }}</td>
                            <td>{{ $d->price }}</td>
                            @switch($d->status)
                            @case(0)
                                <td class="bg-danger text-white"> Disable</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                            @endswitch
                            
                            <td class="text-center">
                                <a href="{{ url('staff/foodtime/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye">View </i></a>
                                <a href="{{ url('staff/foodtime/'.$d->id.'/edit') }}" class="btn btn-secondary btn-sm mr-1"><i class="fa fa-edit"> Edit </i></a> 
                                @switch($d->status)
                                @case(1)
                                <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/foodtime/'.$d->id.'/disable') }}" class="btn btn-danger btn-sm"><i class="fa fa-ban">Disable</i></a>
                                        @break
                                @case(0)
                                <a href="{{ url('staff/foodtime/'.$d->id.'/active') }}" class="btn btn-success btn-sm"><i class="fa fa-check">Active</i></a>
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

