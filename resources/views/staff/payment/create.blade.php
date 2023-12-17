@extends('staff/layout')
@section('title', 'Create Payment')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Payment
            <a href="{{ url('staff/payment') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.payment.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="30%" >Select Student</th>
                            <td>
                                <select required name="student_id" class="form-control" width="70%" id="select_student">
                                    <option value="0">--- Select Student ---</option>
                                    @foreach ($studentdata as $st)
                                    <option value="{{$st->id}}">{{$st->name}} - {{$st->rollno}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
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
                                <th>Mobile</th>
                                <td><input required name="mobileno" type="text" class="form-control"></td>
                            </tr>
                    <tr>
                        <th>Amount</th>
                        <td><input required name="amount" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Payment Status <span class="text-danger">*</span></th>
                            <td><select required name="status" class="form-control room-list">
                                <option value="0">--- Select Status ---</option>
                                <option value="1">Accepted</option>
                                <option value="0">On Process</option>
                            </select></td>
                        </tr> 
                    <tr>
                        <td colspan="2">
                            <input name="staff_id" type="hidden" value="{{ Auth::guard('staff')->user()->id }}">
                            <input name="createdby" type="hidden" value="Staff name :{{ Auth::guard('staff')->user()->name }}">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

    @section('scripts')
    <!-- Add Search in select Options custom scripts -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
        $(function(){
         $("#select_student").select2();
        }); 
       </script>
    @endsection
@endsection

