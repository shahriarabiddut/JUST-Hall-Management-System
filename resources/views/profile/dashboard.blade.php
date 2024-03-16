@extends('layout')
@section('title', 'Student Dashboard')

@section('content')
@if(Session::has('danger'))
            <div class="p-2 mb-1 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
@endif
@if (Auth::user()->hall_id!=0 && Auth::user()->hall_id!=null)
<!-- Content Row For Order Spent of Current Month -->
<div class="card-header p-1 bg-success my-1">
    <h6 class="p-3 font-weight-bold text-white bg-success m-1">
        You have Spent this Month : {{ $sumofthatmonth }} Taka | [ Food item may be changed (Example - Instead of Chiken,Fish may be served)]</h6>
</div>

<!-- Content Row For Order Data of Next Day -->

    <div class="row text-white bg-info m-1 p-1 card-header">
      <div class="col-md-6">
        <h4 class=" pt-2 font-weight-bold">My Orders For Next Day </h4>
      </div>
      <div class="col-md-6 font-weight-bold">
        <i class="fa fa-clock"></i>
        <h6 id="hours" class="d-inline"></h6>
        <h6 id="mins" class="d-inline"></h6>
        <h6 id="secs" class="d-inline"></h6>
        <h6 class="d-inline"> remaining to order today!</h6>
        <h2 id="end" class="d-inline"></h2>
      </div>
    </div>

<div class="row">

    @foreach ($results as $key=> $result)

        @if(isset($result))
        <div class="col-sm-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 
                @switch($resulttitle[$key]->title)
                    @case('Lunch')
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
                    @case('Lunch')
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
            @if($result!=0)
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
                            

                @else
                    @if(isset($remainingTime))
                        @if ($remainingTime)
                        <p class="text-white bg-warning p-4">You have not ordered for {{ $resulttitle[$key]->title }} Meal yet</p>
                        
                        <a href="{{ route('student.order.createOrder',$resulttitle[$key]->id) }}" class="btn btn-danger btn-large btn-block"> ORDER From Food Menu  </a>
                        @else
                        <p class="text-white bg-danger p-4">Your {{ $resulttitle[$key]->title }} Meal Order Time have been passed</p>
                        @endif
                    @endif
                    
                @endif
                </div>
            </div>
        </div>
        @endif
        
    @endforeach


   
    {{-- @foreach ($results as $key=> $result)
        
        <div class="col-sm-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 
                @switch($resulttitle[$key]->title)
                    @case('Lunch')
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
                    @case('Lunch')
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

    @endforeach --}}

</div>
@else
<div class="card-header p-1 bg-success my-1">
    <h6 class="p-3 font-weight-bold text-white bg-success m-1">
        Welcome to System ! {{ Auth::user()->name }}.</h6>
        <!--<p>Email Verification to access system is currently off due to testing purpose!</p>-->
        
</div>
@endif
@section('scripts')

<!-- JavaScript code to calculate and display the remaining time -->
    <script>
        // The data/time we want to countdown to
        var countDownDate = new Date("<?php echo $remainingTime; ?>").getTime();
    
        // Run myfunc every second
        var myfunc = setInterval(function() {
    
        var now = new Date().getTime();
        var timeleft = countDownDate - now;
            
        // Calculating the days, hours, minutes and seconds left
        var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
            
        // Result is output to the specific element
        
        document.getElementById("hours").innerHTML = hours + " Hours " 
        document.getElementById("mins").innerHTML = minutes + " Minutes" 
        document.getElementById("secs").innerHTML = seconds + " Seconds " 
            
        // Display the message when countdown is over
        if (timeleft < 0) {
            clearInterval(myfunc);
            document.getElementById("hours").innerHTML = "" 
            document.getElementById("mins").innerHTML = ""
            document.getElementById("secs").innerHTML = ""
            document.getElementById("end").innerHTML = "TIME UP!!";
        }
        }, 1000);
        </script>
       
@endsection
@endsection