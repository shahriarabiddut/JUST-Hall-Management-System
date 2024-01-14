@extends('staff/layout')
@section('title', 'Payment Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Payment Details of <span class="bg-warning">{{ $data->students->rollno }} </span> 
            <a href="{{ url('staff/payment') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
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
                        <td>
                            @switch($data->transaction_id)
                        @case(0)
                            Cash
                                @break
                        @default
                        SSLCOMMERZ
                    @endswitch
                        </td>
                    </tr>
                    @switch($data->transaction_id)
                        @case(0)
                            Cash
                                @break
                        @default
                        <th>Transaction ID</th>
                        <td> {{ $data->transaction_id }} </td>
                    @endswitch
                    <tr>
                        <th>Mobile No</th>
                        <td>{{ $data->phone }}</td>
                    </tr><tr>
                        <th>Created By</th>
                        <td>{{ $data->name }}</td>
                    </tr><tr>
                        <th>Created Date</th>
                        <td>{{ $data->created_at }}</td>
                    </tr><tr>
                        <th>Status</th>
                        @switch($data->status)
                        @case('Processing')
                           <td class="bg-warning text-white"> Processing</td>
                               @break
                        @case('Accepted')
                        <td class="bg-success text-white"> Accepted</td>
                            @break
                        @case('Rejected')
                        <td class="bg-danger text-white"> Rejected</td>
                            @break
                        @default
                           <td>   No Action Taken </td>
                    @endswitch
                    </tr>
                    @if($data->status == 'Accepted' || $data->status =='Rejected')
                    <tr>
                        <th>Accepted By</th>
                        @switch($data->status)
                        @case('Accepted')
                        <td class="bg-success text-white"> Accepted by {{ $data->staff->name }}</td>
                            @break
                        @case('Rejected')
                        <td class="bg-danger text-white"> Rejected by {{ $data->staff->name }}</td>
                            @break
                    @endswitch
                    </tr>
                    @endif
                    <tr>
                        @if($data->status == 'Accepted' || $data->status =='Rejected')
                        @switch($data->status)
                                @case('Accepted')
                                <th>Accepted Date</th>
                                <td class="bg-success text-white">{{ $data->updated_at }} </td>
                                    @break
                                @case('Rejected')
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

