@extends('staff/layout')
@section('title', 'Create Food Item')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Food Item </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Food Item
            <a href="{{ url('staff/food') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.food.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                    <th>Select Food Time<span class="text-danger">*</span></th>
                        <td>
                            <select required name="food_time_id" class="form-control">
                                <option value="0">--- Select Food Time ---</option>
                                @foreach ($food_time as $ft)
                                <option value="{{$ft->id}}">{{$ft->title}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Food Name<span class="text-danger">*</span></th>
                        <td><input required name="food_name" type="text" class="form-control"></td>
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

