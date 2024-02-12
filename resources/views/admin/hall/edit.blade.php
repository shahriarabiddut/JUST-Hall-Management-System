@extends('admin/layout')
@section('title', 'Edit Hall')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Hall : {{ $data->title }}
            <a href="{{ url('admin/hall/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('admin.hall.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <td><input name="title" value="{{ $data->title }}" type="text" class="form-control"></td>
                        </tr><tr>
                            <th>Select Provost<span class="text-danger">*</span></th>
                                <td>
                                    <select name="staff_id" class="form-control">
                                        @foreach ($provost as $ft)
                                        <option @if ($data->staff_id==$ft->id)
                                            @selected(true)
                                        @endif
                                         value="{{$ft->id}}">{{$ft->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>  
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="staff_id_old" value="{{ $data->staff_id }}">
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

