@extends('staff/layout')
@section('title', 'Import Student From CSV')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Import Student From CSV File</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary"> Upload the CSV File
            <a href="{{ url('staff/student') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('staff.student.bulkUpload') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Format (Excel)</th>
                            <td>Column name should be in serial - rollno,name,email,dept,session or Error May Occur!</td>
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
    @endsection
@endsection

