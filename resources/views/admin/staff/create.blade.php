@extends('admin/layout')
@section('title', 'Add New Staff')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Staff
            <a href="{{ url('admin/staff') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Select Hall</th>
                            <td>
                                <select required name="hall_id" class="form-control">
                                    <option>--- Select Hall ---</option>
                                    <option value="0">--- N/A ---</option>
                                    @foreach ($halls as $hall)
                                    <option value="{{ $hall->id }}">{{ $hall->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Select User Type</th>
                            <td>
                                <select required name="type" class="form-control">
                                    <option value="0">--- Select User Type ---</option>
                                    
                                    <option value="staff">Staff</option>
                                     <option value="provost">Provost</option>
                                     <option value="aprovost">Assistant Provost</option>
                                     <option value="officer">Officer</option>
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input required name="email" type="email" class="form-control" value="{{ old('email') }}"></td>
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

