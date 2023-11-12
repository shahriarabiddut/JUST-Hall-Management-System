@extends('layout')
@section('title', 'Create Order For Meal')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Order Meal </h1>
        <!-- Session Messages Starts -->

        @if(Session::has('danger'))
        <div class="p-3 mb-2 bg-danger text-white">
            <p>{{ session('danger') }} </p>
        </div>
        @endif
        <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Order 
            <a href="{{ url('student/order') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h6>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('student.order.storeAdvance') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                    <th>Order Type<span class="text-danger">*</span></th>
                        <td>
                        <input readonly value="{{$food_time->title}}" name="order_type" type="text" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Advance Order Date<span class="text-danger">*</span></th>
                            <td>
                            <input id='date' name="date" type="date" class="form-control">
                            </td>
                        </tr>
                    <tr>
                        <th>Select Food<span class="text-danger">*</span></th>
                            <td>
                                <select required name="food_item_id" class="form-control">
                                    <option value="0">--- Select Food ---</option>
                                    @foreach ($food as $ft)
                                    <option value="{{$ft->id}}">{{$ft->food_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    
                    <tr>
                        <th> Quantity <span class="text-danger">*</span></th>
                            <td><select required name="quantity" class="form-control room-list">
                                @if (isset($dataquantity))
                                <option value="0">--- Select ---</option>
                                <option value="1">1</option>
                                @else
                                <option value="0">--- Select ---</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                @endif
                                
                            </select></td>
                        </tr> 
                    <tr>
                        <td colspan="2">
                            <input value="{{ Auth::user()->id }}" name="student_id" type="hidden" class="form-control">
                            <input value="{{ $food_time->id }}" name="food_time_id" type="hidden" class="form-control">
                            <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

    @section('scripts')
    <script type="text/javascript">
        // Hiding Old Dates
        const dateField1 = document.getElementById('date');
        const currentDate = new Date();
        // Add one day
        currentDate.setDate(currentDate.getDate() + 2);
        // Format the date as ISO string
        const tomorrow = currentDate.toISOString().split('T')[0];
        dateField1.setAttribute('min', tomorrow);
        // dateField1.setAttribute('max', tomorrow);

        //Auto Input Date For tommorow
        let currentDatex = new Date();
        let month = currentDatex.getMonth() + 1;
        if(month<=9){
            month='0'+month;
        }
        let day = currentDatex.getDate()+1;
        if(day<=9){
            day='0'+day;
        }
        let year = currentDatex.getFullYear()
        dateField1.value = year + "-"+month+"-"+day;
        
        // Hiding Old Dates
        </script>
    @endsection
@endsection

