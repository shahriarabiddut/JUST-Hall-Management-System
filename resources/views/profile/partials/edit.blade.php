@extends('layout')
@section('title', ' Edit Profile | Student Dashboard')

@section('content')
<!-- Page Heading -->

    <div class="container py-5">
    <h1 class="border border-secondary rounded h3 mb-2 text-gray-800 p-2 bg-white"> Editing Profile </h1>

    <div class="table-responsive">
        <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <th>Roll No <span class="text-danger">*</span></th>
                    <td><input readonly name="rollno" type="number" class="form-control" value="{{ $user->rollno }}"></td>
                </tr>
                <tr>
                    <th>Full Name <span class="text-danger">*</span></th>
                    <td><input required name="name" type="text" class="form-control" value="{{ $user->name }}"></td>
                </tr>
                <tr>
                    <th>Email <span class="text-danger">*</span></th>
                    <td><input required name="email" type="email" class="form-control" value="{{ $user->email }}"></td>
                </tr>
                <tr>
                    <th>Department <span class="text-danger">*</span></th>
                    <td><input required name="dept" type="text" class="form-control" value="{{ $user->dept }}" placeholder="example : CSE"></td>
                </tr>
                <tr>
                    <th>Session <span class="text-danger">*</span></th>
                    <td><input required name="session" type="text" class="form-control" value="{{ $user->session }}" placeholder="example : 2017-18"></td>
                </tr><tr>
                    <th>Masters <span class="text-danger">*</span></th>
                    <td><select required name="ms" id="" required class="form-control">
                        <option @if($user->ms==1) selected @endif  value="1"> Yes </option>
                        <option @if($user->ms==0) selected @endif   value="0"> No </option>
                    </select></td>
                </tr><tr>
                    <th>Mobile No <span class="text-danger">*</span></th>
                    <td><input required name="mobile" type="text" maxlength="11" class="form-control" value="{{ $user->mobile }}"></td>
                </tr><tr>
                    <th>Photo</th>
                    <td><input name="photo" type="file">
                        <input name="prev_photo" type="hidden" value="{{ $user->photo }}">
                        <img width="100" src="{{$user->photo ? asset('storage/'.$user->photo) : ''}}" >
                    </td>
                </tr><tr>
                    <th>Address</th>
                    <td><textarea name="address" class="form-control">{{ $user->address }}</textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <input name="userid" type="hidden" value="{{ $user->id }}">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        </div>
    </div>



@section('scripts')

@endsection
@endsection