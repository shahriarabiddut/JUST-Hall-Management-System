@extends('layout')
@section('title', 'Food Menu ')

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Food Menu</h1>
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
<div class="row">
    @foreach ($FoodTime as $key=> $result)
        
        <div class="col-sm-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 
                @switch($result->title)
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
                        {{ $result->title }} Orders <i class="fas 
                    @switch($result->title)
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
                        <table class="table table-bordered float-left" width="50%" >
                            <tbody>
                                
                                @foreach ($foods[$key] as $i => $food)
                                <tr><th>{{ $food->food_name }}</th></tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        
                    </div>
                    <a href="{{ route('student.order.createOrder',$result->id) }}" class="btn 
                        @switch($result->title)
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
                        btn-large btn-block text-white"> <b>ORDER</b></a>
                        <a href="{{ route('student.order.createOrderAdvance',$result->id) }}" class="btn btn-large btn-block text-white bg-dark" ><b>Advance ORDER </b> </a>
                </div>
            </div>
        </div>

    @endforeach

</div>
    @section('scripts')
    @endsection
@endsection

