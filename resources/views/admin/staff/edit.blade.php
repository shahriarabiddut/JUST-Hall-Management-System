@extends('admin/layout')
@section('title', 'Edit Staff')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Edit Staff : {{ $data->name }}
            <a href="{{ url('admin/staff/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('admin.staff.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Photo</th>
                        <td>
                            <table class="table table-bordered">
                                <td>
                                    <input name="photo" type="file">
                                </td>
                            <td> <img width="100" src="{{$data->photo ? asset('storage/'.$data->photo) : ''}}" >
                            </td>
                            <input name="prev_photo" type="hidden" value="{{ $data->photo }}"></table>
                            
                    </tr>
                    <tr>
                        <th>Full Name <span class="text-danger">*</span></th>
                        <td><input required name="name" type="text" class="form-control" value="{{ $data->name }}"></td>
                    </tr><tr>
                        <th>Bio</th>
                        <td><textarea name="bio" class="form-control">{{ $data->bio }}</textarea></td>
                    </tr><tr>
                        <th>Address <span class="text-danger">*</span></th>
                        <td>
                            <input required name="address" type="text" value="{{ $data->address }}" class="form-control">
                        </td>
                    </tr><tr>
                        <th>Phone Number<span class="text-danger">*</span></th>
                        <td><input required name="phone" type="text" class="form-control" value="{{ $data->phone }}" maxlength="11"></td>
                    </tr>
                    <tr>
                        <th>Select User Type</th>
                        <td>
                            <select required name="type" class="form-control">
                                <option value="0">--- Select User Type ---</option>
                                
                                <option @if ($data->type=='staff')
                                    @selected(true)
                                @endif
                                 value="staff">Staff</option>
                                 <option @if ($data->type=='provost')
                                    @selected(true)
                                @endif
                                 value="provost">Provost</option>
                                 <option @if ($data->type=='provost')
                                    @selected(true)
                                @endif
                                 value="aprovost">Assistant Provost</option>
                            </select>
                        </td>
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

