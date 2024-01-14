@extends('staff/layout')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
<script src="{{ asset('js/jquery-searchbox.js') }}"></script>
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
                                <select required name="student_id" class="form-control js-searchBox" id="select_student" width="70%" id="select_student">
                                    <option value="0">--- Select Student ---</option>
                                    @foreach ($studentdata as $st)
                                    <option value="{{$st->id}}">{{$st->name}} - {{$st->rollno}}</option>
                                    @endforeach
                                </select>
                            </td>
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
                                <option value="Accepted">Accepted</option>
                                <option value="Processing">On Process</option>
                            </select></td>
                        </tr> 
                    <tr>
                        <td colspan="2">
                            <input name="staff_id" type="hidden" value="{{ Auth::guard('staff')->user()->id }}">
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
    @endsection
@endsection

