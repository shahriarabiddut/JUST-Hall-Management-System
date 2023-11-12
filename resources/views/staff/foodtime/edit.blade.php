@extends('staff/layout')
@section('title', 'Edit Food Time')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Editing Food Time : {{ $data->title }}</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Food Time
            <a href="{{ url('staff/foodtime/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.foodtime.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <td><input readonly name="title" value="{{ $data->title }}" type="text" class="form-control"></td>
                        </tr><tr>
                            <th>Detail</th>
                            <td>
                            <textarea name="detail" id="" cols="10" rows="4"class="form-control">{{ $data->detail}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Food Price<span class="text-danger">*</span></th>
                            <td><input required value="{{ $data->price }}" name="price" type="number" class="form-control" step="0.01"></td>
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

