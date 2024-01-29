@extends('staff/layout')
@section('title', 'Create Room Type')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Room Type
            <a href="{{ url('staff/roomtype') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('staff.roomtype.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Title</th>
                        <td><input name="title" type="text" class="form-control"></td>
                    </tr><tr>
                        <th>Price</th>
                        <td><input name="price" type="number" class="form-control"></td>
                    </tr><tr>
                        <th>Details</th>
                        <td><textarea name="details" class="form-control"></textarea></td>
                    </tr><tr>
                        <th>Gallery</th>
                        <td><input name="imgs[]" type="file" multiple></td>
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

