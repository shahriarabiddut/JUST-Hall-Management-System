@extends('admin/layout')
@section('title', 'Orders Search by date ')

@section('content')

<div class="card-header p-1 my-1 bg-info">
    <h3 class="m-0 p-2 font-weight-bold text-white bg-info">Total Orders Search by date </h3>
</div>
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
            <div class="card shadow mb-4 ">
                <div class="card-header p-1">
                    <div class="float-left bg-subtle text-white p-1 m-1">
                          <form onsubmit="handleSubmit(event)"  method="POST" class="p-1" action="{{ route('admin.orders.searchByHistory') }}">
                            <div class="form-row rounded">
                            @csrf
                        <div class="col-md-4 mt-1">
                            <select class="form-control" required name="hall_id" id="">
                                <option value="0">-- Select Hall --</option>
                                @foreach ($halls as $ft)
                                <option @if($hall_id == $ft->id) selected @endif value="{{$ft->id}}">{{$ft->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-1">
                            <input  class="form-control" required type="date" value="{{ $date }}" id="search-date" name="date">
                        </div>
                        <div class="col-md-4 mt-1">
                            <button class="form-control btn btn-info" type="submit">Search</button>
                        </div>
                        </div>
                          </form>
                    </div>
                <h6 class="m-0 font-weight-bold text-primary p-1"><a href="{{ route('admin.orders.index') }}" class="float-right btn btn-success btn-sm  p-1"> <i class="fa fa-arrow-left"></i> All Orders</a> </h6>
    
            </div>
            </div>

            <!-- Content Row For Order Data of Selected Date -->
<div class="row">

    @foreach ($results as $key=> $result)
        
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
            </div>
        </div>

    @endforeach

</div>
    @section('scripts')
    
    @endsection
@endsection

