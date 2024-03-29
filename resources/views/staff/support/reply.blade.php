@extends('staff/layout')
@section('title', 'Reply Support Ticket')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Reply on Support Ticket
            <a href="{{ url('staff/support') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ url('staff/support/'.$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>TickeNO</th>
                        <td>{{ $data->id }} </td>
                    </tr>
                    <tr>
                        <th>Ticket By</th>
                        <td>
                            @if ($data->student==null)
                                    User Deleted
                            @else
                                <b>{{ $data->student->name }} - {{ $data->student->rollno }}</b>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{ $data->subject }}</td>
                    </tr><tr>
                        <th>Details</th>
                        <td>{{ $data->message }}</td>
                    </tr>
                    <tr>
                        <th>Status Update <span class="text-danger">*</span></th>
                            <td><select required name="status" class="form-control room-list">
                                <option value="0">--- Select Status ---</option>
                                <option value="1">Solved</option>
                                <option value="2">On Process</option>
                            </select></td>
                        </tr>
                    <tr>
                        <th>Reply</th>
                        <td>
                        <textarea required name="reply" id="" cols="10" rows="4" class="form-control"></textarea>
                        </td>
                    </tr><tr>
                        <td colspan="2">
                            <input type="hidden" name="repliedby" value="{{ Auth::user()->id }}">
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

