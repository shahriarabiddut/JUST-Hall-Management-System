@extends('admin/layout')
@section('title', 'Room Type Details')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"> Room Type Details </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Type Details of {{ $data->title }} room
            <a href="{{ url('admin/roomtype') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> 
                
        </h6>
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
                    </tr><tr>
                        <td colspan="2">
                            <a href="{{ url('admin/roomtype/'.$data->id.'/edit') }}" class="float-right btn btn-info btn-sm"><i class="fa fa-edit"> Edit {{ $data->title }}  </i></a>
                        </td>
                        
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

