@extends('admin/layout')
@section('title', 'Edit Hall')
@section('content')

    @if(Session::has('danger'))
    <div class="p-3 mb-2 bg-danger text-white">
        <p>{{ session('danger') }} </p>
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Editing Hall : {{ $data->title }}
            <a href="{{ url('admin/hall/'.$data->id) }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('admin.hall.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <td><input required name="title" value="{{ $data->title }}" type="text" class="form-control"></td>
                        </tr><tr>
                            <th>Bangla Title</th>
                            <td><input required name="banglatitle" value="{{ $data->banglatitle }}" type="text" class="form-control"></td>
                        </tr>
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
    @endsection
@endsection

