@extends('staff/layout')
@section('title', 'Edit Room')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Room : {{ $data->title }}
            <a href="{{ url('staff/rooms/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.rooms.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Title</th>
                        <td><input name="title" value="{{ $data->title }}" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Select Room Type</th>
                        <td>
                            <select name="rt_id" class="form-control">
                                @foreach ($roomtypes as $rt)
                                <option @if ($data->room_type_id==$rt->id)
                                    @selected(true)
                                @endif
                                 value="{{$rt->id}}">{{$rt->title}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Seats</th>
                        <td><input required name="totalseats" type="number" class="form-control" value="{{ $data->totalseats }}"></td>
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

