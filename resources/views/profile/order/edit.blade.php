@extends('layout')
@section('title', 'Edit Order')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Order : Order No {{ $data->id }}
            <a href="{{ url('student/order/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.order.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                        <th>Select Food<span class="text-danger">*</span></th>
                            <td>
                                <select name="food_item_id" class="form-control">
                                    @foreach ($foods as $ft)
                                    <option @if ($data->food_item_id==$ft->id)
                                        @selected(true)
                                    @endif
                                     value="{{$ft->id}}">{{$ft->food_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
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

