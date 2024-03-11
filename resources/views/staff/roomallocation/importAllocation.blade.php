@extends('staff/layout')
@section('title', 'Allocate Student From CSV')
@section('content')


    <!-- Page Heading -->
    <h2 class="h3 mb-2 text-gray-800">Allocate Student From CSV File</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary"> Upload the CSV File
            <a href="{{ route('staff.roomallocation.index') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('staff.roomallocation.bulkUpload') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Format (Excel)</th>
                            <td>Column name should be in serial - roomtitle, rollno, position or Error May Occur! </td>
                        </tr>
                    <tr>
                        <th style="width: 50%">File</th>
                        <td><input name="file" type="file" ></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary">Upload</button>
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

