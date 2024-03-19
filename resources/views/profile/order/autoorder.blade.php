@extends('layout')
@section('title', 'Order Details')
@section('content')
            @if(Session::has('success'))
            <div class="p-3 mb-2 bg-success text-white">
                <p>{{ session('success') }} </p>
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="p-3 mb-2 bg-danger text-white">
                <p>{{ session('danger') }} </p>
            </div>
            @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Auto Order Daily 
            <a href="{{ route('student.order.foodmenu') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View Food Menu </a> </h3>
        </div> 
        <div class="card-body">
            @if (Auth::user()->autoOrder==null)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <tr>
                        <th>Enroll For Auto Order</th>
                        <td>
                            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.order.autoorderon') }}" enctype="multipart/form-data">
                                @csrf
                            <input value="{{ Auth::user()->id }}" name="user_id" type="hidden" class="form-control">
                            <input value="{{ Auth::user()->hall_id}}" name="hall_id" type="hidden" class="form-control">
                            <button type="submit" class="btn btn-info btn-block"> Start Auto Order Feature </button>
                            </form>
                        </td>
                    </tr>
                    
                </table>
            </div>
            @else
            @php $orders = json_decode(Auth::user()->autoOrder->orders, true);@endphp
            <div class="table-responsive">
                <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('student.order.autoorderupdate',Auth::user()->autoOrder->id) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th>Auto Order Status</th>
                            <td colspan="2">
                                <select required name="status" class="form-control">
                                            <option @if (Auth::user()->autoOrder->status=='1') selected @endif value="1">Active</option>
                                            <option @if (Auth::user()->autoOrder->status=='0') selected @endif value="0">Disabled</option>
                                        </select>   
                            </td>
                        </tr>
                        @if (Auth::user()->autoOrder->status=='1')
                        <tr>
                            <td colspan="3"> If any food is disabled on a day no order will be placed for that time!</td>
                        </tr>
                        <tr>
                            <th>Day</th>
                            <th>Lunch</th>
                            <th>Dinner</th>
                        </tr>
                        <tr>
                            <th>Saturday</th>
                            <td><select name="saturday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['1']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="saturdayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['8']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                </td>
                        </tr>
                        <tr>
                            <th>Sunday</th>
                            <td><select name="sunday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['2']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="sundayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['9']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                        </td>
                        </tr>
                        <tr>
                            <th>Monday</th>
                            <td><select name="monday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['3']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="mondayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['10']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                        </td>
                        </tr>
                        <tr>
                            <th>Tuesday</th>
                            <td><select name="tuesday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['4']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="tuesdayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['11']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                        </td>
                        </tr>
                        <tr>
                            <th>Wednesday</th>
                            <td><select name="wednesday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['5']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="wednesdayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['12']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                        </td>
                        </tr>
                        <tr>
                            <th>Thursday</th>
                            <td><select name="thursday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['6']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="thursdayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['13']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                        </td>
                        </tr>
                        <tr>
                            <th>Friday</th>
                            <td><select name="friday" class="form-control">
                                            <option value="0">--- Select Food ---</option>
                                            @foreach ($foods as $ft)
                                            <option @if ($orders['7']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                            @endforeach
                                        </select>
                                    
                            </td>
                            <td><select name="fridayn" class="form-control">
                                <option value="0">--- Select Food ---</option>
                                @foreach ($foods as $ft)
                                <option @if ($orders['14']==$ft->id) selected @endif value="{{$ft->id}}">{{$ft->food_name}}</option>
                                @endforeach
                            </select>
                        
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            @endif
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

