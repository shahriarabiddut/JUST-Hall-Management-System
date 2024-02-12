@extends('staff/layout')
@section('title', 'Room Type Details')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Room Type Details of {{ $data->title }} room
            <a href="{{ url('staff/roomtype') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> 
                
        </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr><tr>
                        <th>Price</th>
                        <td>{{ $data->price }}</td>
                    </tr><tr>
                        <th>Details</th>
                        <td>{{ $data->details }}</td>
                    </tr><tr>
                        <th>Gallery Images</th>
                        <td>
                        <table class="table table-bordered">
                            <tr>
                                @foreach ($data->roomtypeimages as $img)
                                <td class="imgcol{{$img->id}}">
                                    <img width="200px" src="{{$img->img_src ? asset('storage/'.$img->img_src) : ''}}" alt="{{$img->img_alt ? asset('storage/'.$img->img_alt) : ''}}">
                                </td>
                                @endforeach
                                
                            </tr>
                        </table>
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

