@extends('staff/layout')
@section('title', 'Add New Staff')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Add New Staff
            <a href="{{ url('staff/staff') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <form method="POST" action="{{ route('staff.staff.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th>Select User Type</th>
                            <td>
                                <select required name="type" class="form-control">
                                    <option>--- Select User Type ---</option>
                                    
                                    <option value="staff">Staff</option>
                                     <option value="provost">Provost</option>
                                     <option value="aprovost">Assistant Provost</option>
                                </select>
                            </td>
                        </tr>
                    <tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input required name="email" type="email" class="form-control"></td>
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

