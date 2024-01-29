@extends('staff/layout')
@section('title', 'Edit Room Type')
@section('content')


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Room Type: {{ $data->title }} 
            <a href="{{ url('staff/roomtype/') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a>
        </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.roomtype.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Title</th>
                        <td><input name="title" value="{{ $data->title }}" type="text" class="form-control"></td>
                    </tr><tr>
                        <th>Price</th>
                        <td><input name="price" type="number" value="{{ $data->price }}" class="form-control"></td>
                    </tr><tr>
                        <th>Details</th>
                        <td><textarea  name="details" class="form-control">{{ $data->details }}</textarea></td>
                    </tr><tr>
                        <th>Gallery Images</th>
                        <td>
                        <table class="table table-bordered">
                            <tr><td><input name="imgs[]" type="file" multiple></td></tr>
                            <tr>
                               
                                @foreach ($data->roomtypeimages as $img)
                                <td class="imgcol{{$img->id}}">
                                    <img width="200px" src="{{$img->img_src ? asset('storage/'.$img->img_src) : ''}}" alt="{{$img->img_alt ? asset('storage/'.$img->img_alt) : ''}}">

                                    <p><button type="button" onclick="return confirm('Are You Sure You want to delete this image?')" class="btn btn-danger btn-sm delete-image" data-image-id="{{$img->id}}"><i class="fa fa-trash"></i></button></p>
                                </td>
                                @endforeach
                                
                            </tr>
                        </table>
                        </td>
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
    <!-- Deleting image -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('.delete-image').on('click',function(){
                let _img_id = $(this).attr('data-image-id');
                let _vm = $(this);
                $.ajax({
                    url:'{{ url("staff/roomtypeImage/delete") }}/'+_img_id,
                    dataType:'json',
                    beforeSend:function(){
                        _vm.addClass('disabled');
                    },
                    success:function(res){
                        if(res.bool==true){
                            $(".imgcol"+_img_id).remove();
                        }
                        _vm.removeClass('disabled');
                    }
                });
            });
            }
        );
    </script>
    @endsection
@endsection

