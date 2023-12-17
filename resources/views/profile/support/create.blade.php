@extends('layout')
@section('title', 'Create Support Ticket')
@section('content')


    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Request Support
            <a href="{{ url('student/support') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
            <form method="POST" action="{{ route('student.support.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                        <th>Subject</th>
                        <td><input required name="subject" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Category <span class="text-danger">*</span></th>
                            <td><select required name="category" class="form-control room-list">
                                <option value="0">--- Select Issue ---</option>
                                <option value="Room change">Room change</option>
                                <option value="Room Issue">Room Issue</option>
                                <option value="Meal Issue">Meal Issue</option>
                                <option value="Complain">Complain</option>
                            </select></td>
                        </tr>
                    <tr>
                        <th>Details</th>
                        <td>
                        <textarea name="message" id="" cols="10" rows="4" class="form-control"></textarea>
                        </td>
                    </tr><tr>
                        <td colspan="2">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
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

