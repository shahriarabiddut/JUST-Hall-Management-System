@extends('admin/layout')
@section('title', 'Hall Details')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Hall Details of <span class="bg-warning"> {{ $data->title }} </span> 
            <a href="{{ url('admin/hall') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>logo</th>
                        <td><img width="100" src="{{$data->logo ? asset('storage/'.$data->logo) : url('images/user.png')}}" alt="Hall Logo Photo"></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>
                        @switch($data->type)
                            @case(0)
                                Girls - মেয়েদের হল
                                    @break
                            @case(1)
                                Boys - ছেলেদের হল
                                @break
                        @endswitch
                    </td>
                    </tr>
                    <tr>
                        <th>Bangla Title</th>
                        <td>{{ $data->banglatitle }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $data->title }}</td>
                    </tr><tr>
                        <th>Provost</th>
                        <td>
                        @foreach ($data->provost as $key => $provost)
                           {{ $key+1  }}. {{ $provost->name }} <br>
                        @endforeach    
                        </td>
                    </tr><tr>
                        <th>Assitant Provost</th>
                        <td>
                        @foreach ($data->aprovost as $key => $aprovost)
                        {{ $key+1  }}. {{ $aprovost->name }} <br>
                        @endforeach    
                        </td>
                    </tr><tr>
                        <th>Status</th>
                        @switch($data->status)
                            @case(0)
                                <td class="bg-warning text-white"> Disabled</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                        @endswitch
                    </tr>
                    <tr>
                        <th>Fixed Cost Honours</th>
                        <td>{{ $data->fixed_cost }}</td>
                    </tr>
                    <tr>
                        <th>Fixed Cost Masters</th>
                        <td>{{ $data->fixed_cost_masters }}</td>
                    </tr>
                    <tr>
                        <th>Token Print</th>
                        @switch($data->enable_print)
                            @case(0)
                                <td class="bg-danger text-white"> Disabled</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                        @endswitch
                    </tr>
                    <tr>
                        <th>Online Payments</th>
                        @switch($data->enable_payment)
                            @case(0)
                                <td class="bg-danger text-white"> Disabled</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                        @endswitch
                    </tr>
                    <tr>
                        <th>Delete</th>
                        @switch($data->enable_delete)
                            @case(0)
                                <td class="bg-danger text-white"> Disabled</td>
                                    @break
                            @case(1)
                            <td class="bg-success text-white"> Active</td>
                                @break
                        @endswitch
                    </tr>
                    {{-- <tr>
                        <th>Created By</th>
                        <td>{{ $data->admin->name }}</td>
                    </tr> --}}
                    {{-- <tr>
                        <td colspan="2">
                            <a onclick="return confirm('Are You Sure? Related all things will be deleted also!')" href="{{ url('admin/hall/'.$data->id.'/delete') }}" class="btn btn-danger btn-sm" title="Remove Data"><i class="fa fa-trash"> DELETE</i></a>
                        </td>
                        
                    </tr> --}}
                   
                    
                </table>
            </div>
        </div>
    </div>
    @section('scripts')
    @endsection
@endsection

