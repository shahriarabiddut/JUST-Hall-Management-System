@extends('admin/layout')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
<script src="{{ asset('js/jquery-searchbox.js') }}"></script>

@section('title', 'Add New Allocation')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Allocation
            <a href="{{ url('admin/roomallocation') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('admin.roomallocation.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="30%" >Select Student</th>
                            <td>
                                <select  required name="user_id" class="js-searchBox" width="70%" id="select_student">
                                    <option value="0">--- Select Student ---</option>
                                    @foreach ($students as $st)
                                    <option value="{{$st->id}}">{{$st->name}} - {{$st->rollno}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <th>Select RoomNo</th>
                            <td>
                                <select required name="room_id" class="form-control room_id" id="select_room">
                                    <option value="0">--- Select RoomNo ---</option>
                                    @foreach ($rooms as $rm)
                                    <option value="{{$rm->id}}">{{$rm->title}}</option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    <th>Position <span class="text-danger">*</span></th>
                        <td><select required name="position" class="form-control room-list">
                            <option value="0">--- Select Position ---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select></td>
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

