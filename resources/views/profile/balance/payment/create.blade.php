@extends('layout')
@section('title', 'Create Payment')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Payment </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Payment to Add Balance
            <a href="{{ url('student/payment') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('student.payments.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        
                    <tr>
                        <tr>
                            <th>Payment Method <span class="text-danger">*</span></th>
                                <td><select required name="payment_method" class="form-control room-list">
                                    <option value="0">--- Select Method ---</option>
                                    <option value="cash">Cash</option>
                                    <option value="bkash">Bkash</option>
                                    <option value="rocket">Rocket</option>
                                    <option value="nogod">Nogod</option>
                                </select></td>
                            </tr> 
                            <tr>
                                <th>Mobile <span class="text-danger">(Only if used mobile banking)</span></th>
                                <td><input required name="mobileno" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Transaction ID <span class="text-danger">(Only if used mobile banking)</span></th>
                                <td><input required name="transid" type="text" class="form-control"></td>
                            </tr>
                    <tr>
                        <th>Amount<span class="text-danger">*</span></th>
                        <td><input required name="amount" type="text" class="form-control"></td>
                    </tr>
                        <td colspan="2">
                            
                            <input name="student_id" type="hidden" value="{{ Auth::user()->id }}">
                            <input name="createdby" type="hidden" value="{{ Auth::user()->name }} : {{ Auth::user()->id }}">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                </tr>
                <td colspan="2">
                    
                    Mobile Banking Details :
                    Bkash : 0000000000
                    Rocket : 0000000000
                    Nagad : 0000000000
                    <span class="text-danger">(Use Send Money Method)</span>
                </td>
            </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

