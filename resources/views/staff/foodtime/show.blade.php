@extends('staff/layout')
@section('title', 'FoodTime Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">FoodTime Details of <span class="bg-warning"> {{ $data->title }} </span> 
            <a href="{{ url('staff/foodtime') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr><tr>
                        <th>Detail</th>
                        <td>{{ $data->detail }}</td>
                    </tr><tr>
                        <th>Price</th>
                        <td>{{ $data->price }} /= Taka</td>
                    </tr><tr>
                        <th>Status</th>
                        @switch($data->status)
                            @case(0)
                                <td class="bg-warning text-white"> Disable</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                        @endswitch
                    </tr><tr>
                        <th>Created Date</th>
                        <td>{{ $data->created_at }}</td>
                    </tr><tr>
                        <th>Created By</th>
                        <td>{{ $data->createdby }}</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('staff/foodtime/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"> DELETE</i></a>
                        </td>
                        
                    </tr> --}}
                   
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

