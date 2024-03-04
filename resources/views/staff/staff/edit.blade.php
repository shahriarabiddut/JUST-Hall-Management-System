@extends('staff/layout')
@section('title', 'Edit Staff')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Edit Staff : {{ $data->name }}
            <a href="{{ url('staff/staff/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('staff.staff.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Photo</th>
                        <td>
                            <table class="table table-bordered">
                                <td>
                                    <input type="file" accept="image/*" id="fileInput" name="photo" onchange="previewImage(event)" class="form-control">
                                    <img id="imagePreview" src="#" alt="Image Preview">
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
                                <option @if ($data->type=='staff') @selected(true) @endif value="staff">Staff</option>
                                <option @if ($data->type=='provost') @selected(true) @endif value="provost">Provost</option>
                                <option @if ($data->type=='aprovost') @selected(true) @endif value="aprovost">Assistant Provost</option>
                                <option @if ($data->type=='officer') @selected(true) @endif
                                 value="officer">Officer</option>
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
    <script>
        function previewImage(event) {
          const file = event.target.files[0];
          const reader = new FileReader();
    
          reader.onload = function() {
            const img = document.getElementById('imagePreview');
            img.src = reader.result;
          }
    
          if (file) {
            reader.readAsDataURL(file);
          }
        }
      </script>
    @endsection
@endsection

