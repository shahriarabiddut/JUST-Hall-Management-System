@extends('admin/layout')
@section('title', 'Create New Staff')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create New Staff</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Staff
            <a href="{{ url('admin/staff') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Select Department</th>
                            <td>
                                <select required name="department_id" class="form-control">
                                    <option value="0">--- Select Department ---</option>
                                    @foreach ($departs as $dp)
                                    <option value="{{$dp->id}}">{{$dp->title}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input required name="email" type="email" class="form-control"></td>
                    </tr>
                    <tr>
                    <th>Password <span class="text-danger">*</span></th>
                        <td><input required name="password" type="password" class="form-control"></td>
                    </tr>
                    <tr>
                   <th>Full Name <span class="text-danger">*</span></th>
                        <td><input required name="name" type="text" class="form-control"></td>
                    </tr><tr>
                        <th>Photo</th>
                        <td><input name="photo" type="file"></td>
                    </tr><tr>
                        <th>Bio</th>
                        <td><textarea name="bio" class="form-control"></textarea></td>
                    </tr><tr>
                        <th>Address <span class="text-danger">*</span></th>
                        <td>
                            <input required name="address" type="text" class="form-control">
                        </td>
                    </tr><tr>
                        <th>Phone Number<span class="text-danger">*</span></th>
                        <td><input required name="phone" type="text" class="form-control" maxlength="11"></td>
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

