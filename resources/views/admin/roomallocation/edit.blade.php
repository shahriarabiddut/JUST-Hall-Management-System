@extends('admin/layout')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
<script src="{{ asset('js/jquery-searchbox.js') }}"></script>
@section('title', 'Edit Room Allocation')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Room Allocation: {{ $data->name }}
            <a href="{{ url('admin/roomallocation/'.$data->id) }}" class="float-right btn btn-success btn-sm mx-1"> <i class="fa fa-arrow-left"></i> Back</a> <a href="{{ route('admin.roomallocation.index') }}" class="float-right btn btn-success btn-sm mx-1"> <i class="fa fa-arrow-left"></i> View All </a></h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('admin.roomallocation.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="30%" >Student</th>
                            <td>
                                @foreach ($students as $st)
                                   @if ($data->user_id==$st->id)
                                   {{$st->name}} - {{$st->rollno}}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    <tr>
                        <th>Select RoomNo</th>
                            <td>
                                <select required name="room_id" class="form-control room_id" id="select_room" onchange="fetchAndPopulateData()">
                                    <option value="0">--- Select RoomNo ---</option>
                                    @foreach ($rooms as $rm)
                                    <option @if ($data->room_id==$rm->id)
                                        @selected(true)
                                    @endif
                                     value="{{$rm->id}}">{{$rm->title}}  @if ($data->room_id==$rm->id) (selected) @endif</option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    <tr>
                    <th>Position <span class="text-danger">*</span></th>
                        <td><select name="position" class="form-control" id="positions">
                        </select></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="old_position" value="{{ $data->position }}">
                            <input type="hidden" name="old_room_id" value="{{ $data->room_id }}">
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
        fetch('{{ url("admin/room") }}/postion/' + selectedValue)
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
                if({{ $data->room_id }} == selectedValue){
                let option = document.createElement("option");
                    option.value = {{ $data->position }};
                    option.text = {{ $data->position }} + '(Old Position)';
                    selectField.add(option);
                }
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

