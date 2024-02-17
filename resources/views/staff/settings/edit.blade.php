@extends('staff/layout')
@section('title', 'Edit Settings')
@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Hall Settings</h1>
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Settings</h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('staff.settings.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Logo</th>
                            <td><input name="logo" type="file" accept="image/*" ></td>
                        </tr>
                    <tr>
                        <th>Print</th>
                        <td>
                            <div class="form-check form-check-inline bg-danger py-2 px-3 text-white rounded-pill">
                                <input class="form-check-input" type="radio" name="print" id="exampleRadios1" value="0" @if($data->enable_print==0) @checked(true) @endif>
                                <label class="form-check-label" for="exampleRadios1">
                                  Off
                                </label>
                              </div>
                              <div class="form-check form-check-inline bg-success py-2 px-3 text-white rounded-pill">
                                <input class="form-check-input" type="radio" name="print" id="exampleRadios2" value="1" @if($data->enable_print==1) @checked(true) @endif>
                                <label class="form-check-label" for="exampleRadios2">
                                 On
                                </label>
                              </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Online Payment</th>
                        <td>
                            <div class="form-check form-check-inline bg-danger py-2 px-3 text-white rounded-pill">
                                <input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="0" @if($data->enable_payment==0) @checked(true) @endif>
                                <label class="form-check-label" for="exampleRadios1">
                                  Off
                                </label>
                              </div>
                              <div class="form-check form-check-inline bg-success py-2 px-3 text-white rounded-pill">
                                <input class="form-check-input" type="radio" name="payment" id="exampleRadios2" value="1" @if($data->enable_payment==1) @checked(true) @endif>
                                <label class="form-check-label" for="exampleRadios2">
                                 On
                                </label>
                              </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Print Secret</th>
                        <td><input required name="secret" value="{{ $data->secret }}" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Fixed Cost Honours</th>
                        <td><input required name="fixed_cost" type="number" value="{{ $data->fixed_cost }}" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Fixed Cost Masters</th>
                        <td><input required name="fixed_cost_masters" type="number" value="{{ $data->fixed_cost_masters }}" class="form-control"></td>
                    </tr> 
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="prev_logo" value="{{ $data->logo }}">
                            <input type="hidden" name="staff_id_old" value="{{ $data->staff_id }}">
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

