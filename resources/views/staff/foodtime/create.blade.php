@extends('staff/layout')
@section('title', 'Create FoodTime')
@section('content')


    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New FoodTime
            <a href="{{ url('staff/foodtime') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.foodtime.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Title</th>
                        <td><input required name="title" type="text" class="form-control"></td>
                    </tr><tr>
                        <th>Detail</th>
                        <td>
                        <textarea name="detail" id="" cols="10" rows="4"class="form-control"></textarea>
                        </td>
                    </tr><tr>
                        <th>Food Price<span class="text-danger">*</span></th>
                        <td><input required name="price" type="number" class="form-control" step="0.01"></td>
                    </tr><tr>
                        <th> Status <span class="text-danger">*</span></th>
                            <td><select required name="status" class="form-control room-list">
                                <option value="0">--- Select Status ---</option>
                                <option value="1">Active</option>
                                <option value="0">Disable</option>
                            </select></td>
                        </tr> 
                    <tr><tr>
                        <td colspan="2">
                            <input name="createdby" type="hidden" value="Staff name :{{ Auth::guard('staff')->user()->name }}">
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

