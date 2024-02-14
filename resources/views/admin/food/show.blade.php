@extends('admin/layout')
@section('title', 'Food Item Details')
@section('content')


    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Food Item Details of <span class="bg-warning"> {{ $data->food_name }} </span> 
            <a href="{{ url('admin/food') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Hall</th>
                        <th>@if ($data->hall==null)
                            N/A
                            @else
                            {{ $data->hall->title }}
                        @endif</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $data->food_name }}</td>
                    </tr>
                    <tr>
                        <th>Food Time</th>
                        @switch($data->foodtime->title)
                            @case('Launch')
                                <td class="bg-warning text-white"> {{ $data->foodtime->title }} <i class="fas fa-sun"></i></td>
                                    @break
                            @case('Dinner')
                            <td class="bg-info text-white"> {{ $data->foodtime->title }} <i class="fas fa-star"></i></td>
                                @break
                            @case('Suhr')
                            <td class="bg-dark text-white"> {{ $data->foodtime->title }} <i class="fas fa-moon"></i></td>
                                @break
                        @endswitch
                    </tr>
                    <tr>
                        <th>Food Price</th>
                        <td>{{ $data->food_time_hall->price }} /= Taka </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $data->status }}</td>
                    </tr>
                    <tr>
                        <th>Created Date</th>
                        @if ($data->created_at!=null)
                        <td>{{ $data->created_at->format('F j , Y')}}</td>
                        @else
                        <td>{{ $data->updated_at->format('F j , Y') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Updated Date</th>
                        <td>{{ $data->updated_at->format('F j , Y') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure?')" href="{{ url('admin/food/'.$data->id.'/delete') }}" class="float-right btn btn-danger btn-sm "><i class="fa fa-trash"> Delete </i></a>
                            <a href="{{ url('admin/food/'.$data->id.'/edit') }}" class="float-left btn btn-info btn-sm mr-1"><i class="fa fa-edit"> Edit {{ $data->title }}  </i></a> 
                            
                        </td>
                        
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

