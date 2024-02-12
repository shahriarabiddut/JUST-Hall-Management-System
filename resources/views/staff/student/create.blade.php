@extends('staff/layout')
@section('title', 'Add New Student')
@section('content')


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary"> Add New Student
            <a href="{{ url('staff/student') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('staff.student.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                    <th>Roll No <span class="text-danger">*</span></th>
                    <td><input required name="rollno" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                   <th>Full Name <span class="text-danger">*</span></th>
                        <td><input required name="name" type="text" class="form-control"></td>
                    </tr><tr>
                        <th>Department <span class="text-danger">*</span></th>
                        <td><input required name="dept" type="text" class="form-control" placeholder="example : CSE"></td>
                    </tr><tr>
                        <th>Session <span class="text-danger">*</span></th>
                        <td><input required name="session" type="text" class="form-control" placeholder="example : 2017-18"></td>
                    </tr><tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input required name="email" type="email" class="form-control"></td>
                    </tr><tr>
                        <th>Password <span class="text-danger">*</span></th>
                        <td><input required name="password" type="password" class="form-control"></td>
                    </tr><tr>
                        <th>Mobile No <span class="text-danger">*</span></th>
                        <td><input required name="mobile" type="text" class="form-control" maxlength="11"></td>
                    </tr>
                    <tr>
                        <th>Masters <span class="text-danger">*</span></th>
                        <td><select required name="ms" id="" required class="form-control">
                            <option value="1"> Yes </option>
                            <option value="0"> No </option>
                        </select></td>
                    </tr><tr>
                        <th>Photo</th>
                        <td><input name="photo" type="file" accept="image/*" ></td>
                    </tr><tr>
                        <th>Address</th>
                        <td><textarea name="address" class="form-control"></textarea></td>
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

