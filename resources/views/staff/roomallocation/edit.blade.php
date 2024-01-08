@extends('staff/layout')
@section('title', 'Edit Room Allocation')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Room Allocation: {{ $data->name }}
            <a href="{{ url('staff/roomallocation/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.roomallocation.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="30%" >Select Student</th>
                            <td>
                                <select required name="user_id" class="form-control"  width="70%" id="select_student">
                                    <option value="0">--- Select Student ---</option>
                                    @foreach ($students as $st)
                                    <option @if ($data->user_id==$st->id)
                                        @selected(true)
                                    @endif
                                     value="{{$st->id}}">{{$st->name}} - {{$st->rollno}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <th>Select RoomNo</th>
                            <td>
                                <select required name="room_id" class="form-control">
                                    <option value="0">--- Select RoomNo ---</option>
                                    @foreach ($rooms as $rm)
                                    <option @if ($data->room_id==$rm->id)
                                        @selected(true)
                                    @endif
                                     value="{{$rm->id}}">{{$rm->title}} </option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    <tr>
                    <th>Seat No <span class="text-danger">*</span></th>
                        <td><select required name="position" class="form-control">
                            <option value="0">--- Select Postion ---</option>
                            <option @if ($data->position =='1') @selected(true) @endif value="1">1</option>
                            <option @if ($data->position =='2') @selected(true) @endif value="2">2</option>
                            <option @if ($data->position =='3') @selected(true) @endif value="3">3</option>
                            <option @if ($data->position =='5') @selected(true) @endif value="4">4</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function(){
         $("#select_student").select2();
        }); 
       </script>
    @endsection
@endsection

