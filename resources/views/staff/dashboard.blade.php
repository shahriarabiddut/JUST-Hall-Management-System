@extends('/staff/layout')
@section('title', 'Staff Dashboard')

@section('content')
@if(Session::has('danger'))
            <div class="p-3 mb-2 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
            @endif
@if(App\Models\RoomRequest::where('flag', 0)->count()!=0)
<!-- Content Row Notificaton -->
<div class="row mt-1 p-2 mx-2 bg-warning text-white mb-2">
    <p> {{ App\Models\RoomRequest::where('flag', 0)->count(); }} Unread Room Allocation Request</p>
</div>
@endif
<!-- Content Row -->
<div class="row">

    <!-- Bookings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Orders {{  $nextDate }}</div> 
                            
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Order::all()->where('date','=',$nextDate)->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Students</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Student::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rooms
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ App\Models\Room::count() }}</div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Staff</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Staff::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row For Order Data of Next Day -->
<div class="row">

    @foreach ($results as $key=> $result)
        @php $orders = 0; @endphp
        <div class="col-sm-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 
                @switch($resulttitle[$key]->title)
                    @case('Launch')
                        bg-warning
                        @break
                    @case('Dinner')
                        bg-info
                        @break
                    @case('Suhr')
                        bg-dark
                        @break
                    @case('Special')
                        bg-danger
                        @break
                    @default
                        bg-secondary
                @endswitch
                ">
                    <h6 class="m-0 font-weight-bold text-white ">
                        {{ $resulttitle[$key]->title }} Orders <i class="fas 
                        @switch($resulttitle[$key]->title)
                    @case('Launch')
                        fa-sun
                        @break
                    @case('Dinner')
                        fa-star
                        @break
                    @case('Suhr')
                        fa-moon
                        @break
                    @case('Special')
                        fa-star
                        @break
                    @default
                        bg-secondary
                @endswitch
                        "></i>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @foreach ($result as $key => $ld)
                                @switch($key)
                                    @case(1)
                                        <table class="p-4 table-bordered float-left" width="50%">
                                            <tbody>
                                        @foreach ($ld as $key => $foods)
                                            <tr><th class="p-4 text-center">{{ $foods->food_name }} </th> </tr>
                                        
                                            @endforeach
                                        </tbody>
                                    </table>
                                        @break
                                    @case(0)
                                        <table class="table-bordered float-right" width="50%">
                                            <tbody>
                                            @foreach ($ld as $key => $foodscount)
                                            <tr><th class="p-4 text-center">{{ $foodscount }}</th> </tr>
                                            @php $orders = $orders + $foodscount; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @break
                                    @default
                                    <table class="table-bordered float-right" width="50%">
                                        <tbody>
                                        <tr><th class="p-4 text-center">No Data Available</th> </tr>
                                        </tbody>
                                    </table>
                                @endswitch
                                @endforeach
                            </div>
                        </div>
                        <h6 class="p-1 text-center">Total Orders - {{ $orders }}</h6>
            </div>
        </div>

    @endforeach

</div>

@section('scripts')
<!-- Page level plugins -->
<script defer src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script defer src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Page level custom scripts -->
<script defer src="{{ asset('js/demo/datatables-demo.js') }}"></script>
{{-- <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
@endsection
@endsection