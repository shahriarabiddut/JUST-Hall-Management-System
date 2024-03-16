@extends('admin/layout')
@section('title', 'Send New Email')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Send New Email
            <a href="{{ url('admin/email') }}" class="float-right btn btn-success btn-sm"> <i class="fa fa-arrow-left"></i> View All </a> </h3>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                   <p class="text-danger"> {{ $error }} </p>
                @endforeach
                @endif
                @if(Session::has('error'))
                    <div class="p-3 mb-2 bg-danger text-white">
                        <p>{{ session('danger') }} </p>
                    </div>
                @endif
            <form onsubmit="handleSubmit(event)"  method="POST" action="{{ route('admin.email.store') }}" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                    <tr>
                   <th>Name <span class="text-danger">*</span></th>
                        <td><input class="form-control" type="text" name="name" placeholder="Name" required {{ old('name') }} ></td>
                    </tr><tr>
                        <th>Email <span class="text-danger">*</span></th>
                        <td><input class="form-control" type="text" name="email" placeholder="Email" required value="{{ old('email') }}"></td></tr>
                    <tr><th>Subject<span class="text-danger">*</span></th>
                        <td><input class="form-control" type="text" name="subject" placeholder="Subject" required value="{{ old('subject') }}"></td>
                    </tr><tr>
                        <th>Message <span class="text-danger">*</span></th>
                        <td><textarea class="form-control" name="message" placeholder="Message"> {{ old('message') }}</textarea></td>
                    </tr><tr>
                        <th>Objective<span class="text-danger">*</span></th>
                        <td>
                            <select class="form-control" aria-label="Default select example" name="objective">
                                <option selected value="none" > Select objective </option>
                                <option value="payment">Payment Issue</option>
                                <option value="subscription">Subscription Message</option>
                              </select>
                              {{-- <input class="form-control" type="text" name="objective" placeholder="Objective" required value="{{ old('objective') }}"> --}}
                            </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="staff_id" value="0">
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

