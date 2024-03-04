@extends('staff/layout')
@section('title', 'Edit Food Item')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Food Item : {{ $data->title }}
            <a href="{{ url('staff/food/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> Go Back </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('staff.food.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                        <th>Select Food Time<span class="text-danger">*</span></th>
                            <td>
                                <select name="food_time_id" class="form-control">
                                    @foreach ($food_time as $ft)
                                    <option @if ($data->food_time_id==$ft->id)
                                        @selected(true)
                                    @endif
                                     value="{{$ft->id}}">{{$ft->title}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Food Name<span class="text-danger">*</span></th>
                            <td><input required value="{{ $data->food_name }}" name="food_name" type="text" class="form-control"></td>
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

