@extends('staff/layout')
@section('title', 'Edit Student')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Student: {{ $data->name }}
            <a href="{{ route('staff.student.show',$data->id) }}" class="float-right btn btn-info btn-sm ml-1"> <i class="fa fa-eye"></i> View Student </a> <a href="{{ route('staff.student.index') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a></h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.student.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Roll No <span class="text-danger">*</span></th>
                        <td><input required name="rollno" type="text" class="form-control" value="{{ $data->rollno }}"></td>
                    </tr>
                    <tr>
                        <th>Department <span class="text-danger">*</span></th>
                        <td><input required name="dept" type="text" class="form-control" value="{{ $data->dept }}"></td>
                    </tr><tr>
                        <th>Session <span class="text-danger">*</span></th>
                        <td><input required name="session" type="text" class="form-control" value="{{ $data->session }}"></td>
                    </tr>
                    <tr>
                        <th>Full Name <span class="text-danger">*</span></th>
                        <td><input required name="name" type="text" class="form-control" value="{{ $data->name }}"></td>
                    </tr><tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input required name="email" type="email" class="form-control" value="{{ $data->email }}"></td>
                    </tr><tr>
                        <th>Mobile No <span class="text-danger">*</span></th>
                        <td><input required name="mobile" type="text" class="form-control" value="{{ $data->mobile }}" maxlength="11"></td>
                    </tr><tr>
                        <th>Photo</th>
                        <td><input name="photo" type="file">
                            <input name="prev_photo" type="hidden" value="{{ $data->photo }}">
                            <img width="100" src="{{$data->photo ? asset('storage/'.$data->photo) : ''}}" >
                        </td>
                    </tr><tr>
                        <th>Address</th>
                        <td><textarea name="address" class="form-control">{{ $data->address }}</textarea></td>
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
    @endsection
@endsection

