@extends('admin/layout')
@section('title', 'Create Room')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Room
            <a href="{{ url('admin/rooms') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Select Hall</th>
                        <td>
                            <select required name="hall_id" class="form-control">
                                <option value="0">--- Select Hall ---</option>
                                @foreach ($halls as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->title }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td><input required name="title" type="text" class="form-control"></td>
                    </tr><tr>
                        <th>Select Room Type</th>
                        <td>
                            <select required name="rt_id" id="type" class="form-control">
                                <option value="0">--- Select Room Type ---</option>
                                @foreach ($roomtypes as $rt)
                                <option value="{{$rt->id}}">{{$rt->title}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Seats</th>
                        <td><input required name="totalseats" id="numberInput" type="number" class="form-control"></td>
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
    <script>
        // Function to extract and update number
        function extractNumberAndDisplay() {
            var selectElement = document.getElementById("type");
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var selectedText = selectedOption.textContent;
            
            // Extract number from selected text
            var numberPattern = /\d+/;
            var number = selectedText.match(numberPattern);

            // Display number in input field
            var numberInput = document.getElementById("numberInput");
            numberInput.value = number;
        }

        // Add event listener to detect changes in the select input
        document.getElementById('type').addEventListener('change', extractNumberAndDisplay);

        // Initial call to set the initial value
        extractNumberAndDisplay();
    </script>

    @endsection
@endsection

