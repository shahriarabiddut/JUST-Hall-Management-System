@extends('staff/layout')
@section('title', 'Orders ')

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

@if ($token==null)
<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary d-inline" >Enter Meal Token No</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('staff.orders.qrcodescan') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Token Number<span class="text-danger">*</span></th>
                        <td><input required name="token_number" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary d-inline" >Scan QR Code</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="section">
                <div id="my-qr-reader">
                </div>
            </div>
    
        <script src="{{ asset('js/html5qrcode.min.js') }}"></script>
        <script src="{{ asset('js/qrcode.js') }}"></script>
        </div>
    </div>
</div>
@else
@php $date = strtotime($token->date); $tokenDate = date("F j, Y", $date);; @endphp
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary d-inline" >Meal Token</h3>
    </div>
    @if ($falseCheck ==1)
    <div class="p-1 mb-1 bg-danger text-white text-center">
        <h3> Token Expired </h3>
    </div>
    @elseif ($falseCheck ==2)
    <div class="p-1 mb-1 bg-danger text-white text-center">
        <h3> Token is not valid Today . Valid Date - {{ $tokenDate }}</h3>
    </div>
    @elseif ($falseCheck ==3)
    <div class="p-1 mb-1 bg-danger text-white text-center">
        <h3> Token is not valid Now. Wait For Dinner Time to Start .</h3>
    </div>
    @else
    <div class="p-1 mb-1 bg-success text-white text-center">
        <h3> Token Valid ! Please Serve </h3>
    </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th width="60%">Meal Type</th>
                        <td width="40%">{{ $token->meal_type }}</td>
                    </tr>
                    <tr>
                        <th>Meal</th>
                        <td>{{ $token->food_name }}</td>
                    </tr>
                    <tr>
                        <th>Token Date</th>
                        <td>{{ $tokenDate }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $token->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Validity Update Time</th>
                        <td>
                            @if ($token->created_at==$token->updated_at)
                                N/A
                            @else
                                {{ $token->updated_at }}
                            @endif
                            </td>
                    </tr>
                    <tr>
                        <th>Order No</th>
                        <td>{{ $token->order_id }}</td>
                    </tr>
                    <tr>
                        <th>Token No</th>
                        <td>{{ $token->id }}</td>
                    </tr>
                    
                </table>
            </table>
        </div>
    </div>
</div>
@endif
    
<style>
    
	<style>.section {
        background-color: #ffffff;
        padding: 50px 30px;
        border: 1.5px solid #b2b2b2;
        border-radius: 0.25em;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
    }
    
    #my-qr-reader {
        padding: 20px !important;
        border: 1.5px solid #b2b2b2 !important;
        border-radius: 8px;
    }
    
    #my-qr-reader img[alt="Info icon"] {
        display: none;
    }
    
    #my-qr-reader img[alt="Camera based scan"] {
        width: 100px !important;
        height: 100px !important;
    }
    
    button {
        padding: 10px 20px;
        border: 1px solid #b2b2b2;
        outline: none;
        border-radius: 0.25em;
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        margin-bottom: 10px;
        background-color: #008000ad;
        transition: 0.3s background-color;
    }
    
    button:hover {
        background-color: #008000;
    }
    
    #html5-qrcode-anchor-scan-type-change {
        text-decoration: none !important;
        color: #1d9bf0;
    }
    
    video {
        width: 100% !important;
        border: 1px solid #b2b2b2 !important;
        border-radius: 0.25em;
    }</style>
</style>
    @section('scripts')
    @endsection
@endsection

