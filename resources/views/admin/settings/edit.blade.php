@extends('admin/layout')
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
            @foreach ($datas as $data)
            <div class="table-responsive">
                <form method="POST" action="{{ url('admin/settings/update/'.$data->id) }}" enctype="multipart/form-data">
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
                                    @case($data->name=='systemname')
                                        Dashboard Header Title
                                    @break
                                    @case($data->name=='backup')
                                        Backup & Update
                                    @break
                                    @default
                                        {{ $data->name }}
                                @endswitch
                                
                            </th>
                            <td width="40%">
                                @switch($data->name)
                                    @case($data->name=='backup')
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
            @endforeach
            
        </div>
    </div>

    @section('scripts')
    @endsection
@endsection

