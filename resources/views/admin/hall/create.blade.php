@extends('admin/layout')
@section('title', 'Add New Hall')
@section('content')


    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Hall
            <a href="{{ url('admin/hall') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('admin.hall.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Title</th>
                        <td><input required name="title" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Select Provost<span class="text-danger">*</span></th>
                            <td>
                                <select required name="staff_id" class="form-control">
                                    <option value="0">--- Select Provost ---</option>
                                    @foreach ($provost as $ft)
                                    <option value="{{$ft->id}}">{{$ft->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    <tr>
                    <th> Status <span class="text-danger">*</span></th>
                        <td><select required name="status" class="form-control room-list">
                            <option value="0">--- Select Status ---</option>
                            <option value="1">Active</option>
                            <option value="0">Disable</option>
                        </select></td>
                    </tr> 
                    <tr>
                        <td colspan="2">
                            <input name="createdby" type="hidden" value="admin name :{{ Auth::guard('admin')->user()->name }}">
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

