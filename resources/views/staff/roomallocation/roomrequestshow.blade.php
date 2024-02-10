@extends('staff/layout')
@section('title', 'Room Request Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Request Details 
                <a href="{{ route('staff.roomallocation.roomrequests') }}" class="float-right btn btn-success btn-sm" target="_self"> <i class="fa fa-arrow-left m-1 p-1"> </i>View All Room Requests</a> 
            </h3>
            
        </div>
        <div class="card-body">
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
            
            <div class="table-responsive">

                <table class="table table-bordered" width="100%">  
                    <tr>
                        <th style="width: 30%;">Status</th>
                        
                        @if ($data->status=='1')
                        <td class="bg-success"> Accepted </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning"> On Queue </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger"> Rejected </td>
                        @else
                        <td> Requested </td>
                        @endif
                        
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>
                            @if ($data->students==null)
                                User Deleted
                            @else
                                {{ $data->students->name }} - {{ $data->students->rollno }}
                            @endif
                        </td>
                    </tr><tr>
                        <th>Room no</th>
                        <td>
                                @if ($data->room_id ==0)
                                    N/A
                                @else
                                    @if ($data->rooms==null)
                                    Room Deleted
                                    @else
                                        {{ $data->rooms->title }} - {{ $data->rooms->RoomType->title }} type
                                    @endif
                                @endif </td>
                    </tr>
                    <tr>
                        <th>Application</th>
                        <td>{!! $data->message !!}</td>
                    </tr><tr>
                        <th>Application Date</th>
                        <td>{{ $data->created_at->format('F j, Y - H:i:s') }}</td>
                    </tr>
                    <tr>    
                        @if ($data->status=='1')
                        <th class="bg-success"> Accepted Date </th>
                        @elseif($data->status=='0')
                        <th class="bg-warning"> Listed Date </th>
                        @elseif($data->status=='2')
                        <th class="bg-danger"> Rejected Date</th>
                        @else
                        <th> Last Checked Date </th>
                        @endif
                        @if ($data->status=='1')
                        <td class="bg-success"> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @elseif($data->status=='0')
                        <td class="bg-warning"> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @elseif($data->status=='2')
                        <td class="bg-danger"> {{ $data->updated_at->format('F j, Y - H:i:s') }}</td>
                        @else
                        <td> {{ $data->updated_at->format('F j, Y - H:i:s') }} </td>
                        @endif
                    </tr>
                    
                    <tr>
                        <th> Action </th>
                        <td class="text-center">
                            @if ($data->status=='3' || $data->status=='0')
                            @if ($data->status!='1')
                            <a href="{{ url('staff/roomallocation/accept/'.$data->id) }}" class="btn btn-success btn-sm m-1"><i class="fa fa-check"> Accept </i></a>
                            @endif
                            @if ($data->status!='1' && $data->status!='2')
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/roomallocation/list/'.$data->id) }}" class="btn btn-warning btn-sm m-1"><i class="fa fa-list" aria-hidden="true"> List </i></a>
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/roomallocation/ban/'.$data->id) }}" class="btn btn-danger btn-sm m-1"><i class="fa fa-ban" aria-hidden="true"> Reject </i></a>
                            @endif
                            @else
                                No Action Needed
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Payment Details </h3>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    @if ($dataPayment!=null)
                    
                    <tr>
                        <th>Status</th>
                        @switch($dataPayment->status)
                                @case('Processing')
                                   <td class="bg-warning text-white"> Processing</td>
                                       @break
                                @case('Completed')
                                <td class="bg-warning text-white"> Completed</td>
                                    @break
                                @case('Accepted')
                                <td class="bg-success text-white"> Accepted by {{ $dataPayment->staff->name }}</td>
                                    @break
                                @case('Rejected')
                                <td class="bg-danger text-white"> Rejected by {{ $dataPayment->staff->name }}</td>
                                    @break
                                @default
                                   <td>{{$dataPayment->status}}</td>
                            @endswitch
                        
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{ $dataPayment->amount }}</td>
                    </tr><tr>
                        <th>Payment Proof</th>
                        <td><img src="{{ asset('storage/'.$dataPayment->proof) }}" alt=""> </td>
                    </tr>
                    <tr>
                        <th>Payment Date</th>
                        <td>{{ $dataPayment->created_at->format('F j,Y') }}</td>
                    </tr>
                    @if ($dataPayment->status == 'Processing')
                    <tr>
                    <td colspan="2">
                        <a href="{{ url('staff/payment/'.$dataPayment->id.'/accept') }}" class="btn btn-success btn-sm"><i class="fa fa-check">Accept</i></a>
                        <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/payment/'.$dataPayment->id.'/reject') }}" class="btn btn-danger btn-sm"><i class="fa fa-ban">Reject</i></a>
                        </td>
                    </tr>
                    @endif
                    
                @else
                <tr>
                    <td colspan="2">
                        No Payment Data Found
                    </td>
                </tr>
                @endif
                </table>
            </div>
            
        </div>
    </div>
    @if($data->status==1)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Allocation
            <a href="{{ url('staff/roomallocation') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('staff.roomallocation.RoomRequestAllocate') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Select RoomNo</th>
                            <td>
                                <select required name="room_id" class="form-control room_id" id="select_room" onchange="fetchAndPopulateData()">
                                    <option value="0">--- Select RoomNo ---</option>
                                    @foreach ($rooms as $rm)
                                    <option value="{{$rm->id}}">{{$rm->title}}</option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    <th>Position <span class="text-danger">*</span></th>
                        <td>
                            <select name="position" class="form-control" id="positions">
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="{{ $data->id }}" name="id">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
    @endif
    @section('scripts')
    <script>
        $(function(){
         $("#select_student").select2();
        }); 
        $(function(){
         $("#select_room").select2();
        }); 
        $('.js-searchBox').searchBox({ elementWidth: '100%'});
        $('.user_id').searchBox({ elementWidth: '100%'});
        $('.room_id').searchBox({ elementWidth: '100%'});
       </script>
       <script>
        function fetchAndPopulateData() {
            let selectedValue = document.getElementById("select_room").value;

            // Make Ajax request to fetch data
            fetch('{{ url("staff/room") }}/postion/' + selectedValue)
                .then(response => response.json())
                .then(data => {
                    // Update the options of the second select field
                    let secondSelectField = document.getElementById("positions");
                    secondSelectField.innerHTML = ""; // Clear existing options
                    let arrayString = data;

                    // Parse the string into a JavaScript array
                    let dataArray = JSON.parse(arrayString);

                    // Get the select field element
                    let selectField = document.getElementById("positions");

                    // Populate the select field with options based on the array
                    dataArray.forEach(function(value) {
                        let option = document.createElement("option");
                        option.value = value;
                        option.text = value;
                        selectField.add(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
        </script>
    @endsection
@endsection
