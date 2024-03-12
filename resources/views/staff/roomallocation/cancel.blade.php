@extends('staff/layout')
@section('title', 'Reason of Removal Room Allocation')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Reason of Removal Room Allocation of {{ $data->students->name }} - {{ $data->students->rollno }} </h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
            <div class="table-responsive">
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('staff.roomallocation.remove') }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Objective <span class="text-danger">*</span></th>
                            <td><select required name="objective" class="form-control room-list">
                                <option value="0">--- Select Objective ---</option>
                                <option value="1">Seat Cancel</option>
                                <option value="2">Rusticate</option>
                            </select></td>
                        </tr>
                    <tr>
                        <th>Report</th>
                        <td>
                        <textarea required name="report" id="" cols="10" rows="4" class="form-control"></textarea>
                        </td>
                    </tr><tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="{{ $data->id }}">
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

