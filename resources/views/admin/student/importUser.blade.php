@extends('admin/layout')
@section('title', 'Import Student From CSV')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary"> Import Student From CSV / Excel File
            <a href="{{ url('admin/student') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('admin.student.bulkUpload') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th> Select Method </th>
                        <td><select id="dropdown" name="email" class="form-control" onchange="updateText()">
                            <option selected value="0">Data Contains No Email</option>
                            <option value="1">Data Contains Email & Mobile</option>
                            <option value="2">Data Contains No Mobile</option>
                        </select></td>
                    </tr>
                    <tr>
                        <th>Format (Excel)</th>
                        <td>Column name should be in serial - <div id="result" class="d-inline">rollno,name,dept,session,mobile or Error May Occur!</div>!</td>
                    </tr>
                    <tr>
                        <th>Hall</th>
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
                        <th style="width: 50%">File</th>
                        <td><input name="file" type="file" ></td>
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
        function updateText() {
    // Get the selected value from the dropdown
    var selectedOption = document.getElementById("dropdown").value;

    // Determine the text to display based on the selected option
    var newText;
    switch (selectedOption) {
        case "0":
            newText = "rollno,name,dept,session,mobile or Error May Occur";
            break;
        case "1":
            newText = "rollno,name,email,dept,session,mobile or Error May Occur";
            break;
        case "2":
            newText = " rollno,name,email,dept,session or Error May Occur";
            break;
        default:
            newText = "Select Method";
    }

    // Update the text of the HTML element
    document.getElementById("result").textContent = newText;
}

    </script>
    @endsection
@endsection

