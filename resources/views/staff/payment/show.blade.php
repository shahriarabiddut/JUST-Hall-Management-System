@extends('staff/layout')
@section('title', 'Payment Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Payment Details of <span class="bg-warning">-- {{ $data->students->rollno }} -- </span> 
            <a href="{{ url('staff/payment') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>PaymentID</th>
                        <td>{{ $data->id }}</td>
                    </tr><tr>
                        <th>Student</th>
                        <td>{{ $data->students->name }} - {{ $data->students->rollno }}</td>
                    </tr><tr>
                        <th>Amount</th>
                        <td>{{ $data->amount }}</td>
                    </tr><tr>
                        <th>Pament Method</th>
                        <td>{{ $data->payment_method }}</td>
                    </tr>
                    @switch($data->payment_method)
                        @case('cash')
                            
                                @break
                        @default
                        <th>Transaction ID</th>
                        <td> {{ $data->transid }} </td>
                    @endswitch
                    <tr>
                        <th>Mobile No</th>
                        <td>{{ $data->mobileno }}</td>
                    </tr><tr>
                        <th>Created By</th>
                        <td>{{ $data->createdby }}</td>
                    </tr><tr>
                        <th>Created Date</th>
                        <td>{{ $data->created_at }}</td>
                    </tr><tr>
                        <th>Status</th>
                            @switch($data->status)
                                @case(0)
                                   <td class="bg-warning text-white"> Checking</td>
                                       @break
                                @case(1)
                                <td class="bg-success text-white"> Accepted</td>
                                    @break
                                @case(2)
                                <td class="bg-danger text-white"> Rejected</td>
                                    @break
                                @default
                                   <td>   No Action Taken </td>
                            @endswitch
                    </tr>
                    @if($data->staff_id)
                    <tr>
                        <th>Accepted By</th>
                        <td>{{ $data->staff->name }}</td>
                    </tr>
                    @endif
                    <tr>
                        @if($data->status ==1 || $data->status ==2)
                        @switch($data->status)
                                @case(1)
                                <th>Accepted Date</th>
                                <td class="bg-success text-white">{{ $data->updated_at }} </td>
                                    @break
                                @case(2)
                                th>Rejected Date</th>
                                <td class="bg-danger text-white"> {{ $data->updated_at }}</td>
                                    @break
                            @endswitch
                        @else
                            <td colspan="2">
                        <a href="{{ url('staff/payment/'.$data->id.'/accept') }}" class="btn btn-success btn-sm"><i class="fa fa-check">Accept</i></a>
                        <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/payment/'.$data->id.'/reject') }}" class="btn btn-danger btn-sm"><i class="fa fa-ban">Reject</i></a>
                        </td>
                        @endif
                    </tr>
                   
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

