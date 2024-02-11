@extends('staff/layout')
@section('title', 'Edit Settings')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Editing Settings</h1>
    <!-- Session Messages Starts -->
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
    <!-- Session Messages Ends -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="bg-info text-white text-center p-2 rounded"> Website </h3>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[0]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Website Title</th>
                            <td width="50%"><input required name="value" type="text" class="form-control" value="{{ $datas[0]->value }}"></td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[2]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Panel Header Title</th>
                            <td width="50%"><input required name="value" type="text" class="form-control" value="{{ $datas[2]->value }}"></td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[8]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Hall Title</th>
                            <td width="50%"><input required name="value" type="text" class="form-control" value="{{ $datas[8]->value }}"></td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[3]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Hall Logo </th>
                            <td width="50%"><input required name="value" type="file" class="form-control" accept="image/*" id="fileInput" onchange="previewImage(event,'imagePreview')" > <br> <img width="100" id="imagePreview" src="{{asset($datas[3]->value)}}" >
                            </td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[4]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Website Favicon</th>
                            <td width="50%"><input required name="value" type="file" class="form-control" accept="image/*" id="fileInput" onchange="previewImage(event,'imagePreview2')" > <br> <img width="100" id="imagePreview2" src="{{asset($datas[4]->value)}}" >
                            </td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <h3 class="bg-primary text-white text-center p-2 rounded"> Fixed Charges </h3>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[1]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Fixed Charges For Hounors Students</th>
                            <td width="50%"><input required name="value" type="text" class="form-control" value="{{ $datas[1]->value }}"></td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[11]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Fixed Charges For Masters Students</th>
                            <td width="50%"><input required name="value" type="text" class="form-control" value="{{ $datas[11]->value }}"></td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <h3 class="bg-warning text-white text-center p-2 rounded"> Print </h3>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[10]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Print Option</th>
                            <td width="50%">
                                <div class="form-check form-check-inline bg-danger py-2 px-3 text-white rounded-pill">
                                    <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="0" @if($datas[10]->value==0) @checked(true) @endif>
                                    <label class="form-check-label" for="exampleRadios1">
                                      Off
                                    </label>
                                  </div>
                                  <div class="form-check form-check-inline bg-success py-2 px-3 text-white rounded-pill">
                                    <input class="form-check-input" type="radio" name="value" id="exampleRadios2" value="1" @if($datas[10]->value==1) @checked(true) @endif>
                                    <label class="form-check-label" for="exampleRadios2">
                                     On
                                    </label>
                                  </div>
                                </td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$datas[9]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="30%">Printing Secret</th>
                            <td width="50%"><input required name="value" type="password" class="form-control" value="" placeholder="Enter Secret Value"></td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            
            {{-- @foreach ($datas as $data)
            <div class="table-responsive">
                <form method="POST" action="{{ route('staff.settings.update',$data->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <tr>
                            <th width="40%">
                                @switch($data->name)
                                    @case($data->name=='title')
                                        Website Title
                                        @break
                                    @case($data->name=='fixed_cost_charge')
                                        Fixed Cost Charge
                                    @break
                                    @case($data->name=='masters_fixed_cost')
                                        Masters Fixed Cost Charge
                                    @break
                                    @case($data->name=='systemname')
                                        Dashboard Header Title
                                    @break
                                    @case($data->name=='print')
                                        Print
                                    @break
                                    @default
                                        {{ $data->name }}
                                @endswitch
                                
                            </th>
                            <td width="40%">
                                @switch($data->name)
                                    @case($data->name=='print')
                                    <div class="form-check form-check-inline bg-danger py-2 px-3 text-white rounded-pill">
                                        <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="0" @if($data->value==0) @checked(true) @endif>
                                        <label class="form-check-label" for="exampleRadios1">
                                          Off
                                        </label>
                                      </div>
                                      <div class="form-check form-check-inline bg-success py-2 px-3 text-white rounded-pill">
                                        <input class="form-check-input" type="radio" name="value" id="exampleRadios2" value="1" @if($data->value==1) @checked(true) @endif>
                                        <label class="form-check-label" for="exampleRadios2">
                                         On
                                        </label>
                                      </div>
                                    @break
                                    @case($data->id==10)
                                    <input required name="value" type="password" class="form-control" value="" placeholder="Enter Secret Value">
                                    @break
                                    @default
                                    <input required name="value" type="text" class="form-control" value="{{ $data->value }}">
                                @endswitch
                            </td>
                            <td width="20%"><button type="submit" class="btn btn-primary">Update</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
                </div>
            @endforeach --}}
            
        </div>
    </div>

    @section('scripts')
    <script>
        function previewImage(event,imagePreview) {
          const file = event.target.files[0];
          const reader = new FileReader();
    
          reader.onload = function() {
            const img = document.getElementById(imagePreview);
            img.src = reader.result;
          }
    
          if (file) {
            reader.readAsDataURL(file);
          }
        }
      </script>
    @endsection
@endsection

