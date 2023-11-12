@extends('layout')
@section('title', ' Change Password | Student Dashboard')

@section('content')
<!-- Page Heading -->

    <div class="container py-5">
    <h1 class="border border-secondary rounded h3 mb-2 text-gray-800 p-2 bg-white"> Editing Profile </h1>

    <div class="table-responsive">
        {{-- Errors --}}
        @if(Session::has('danger'))
        <div class="p-3 mb-2 bg-danger text-white">
            <p>{{ session('danger') }} </p>
        </div>
        @endif
        @error('newPassword')
        <div class="p-3 mb-2 bg-danger text-white">{{ $message }}</div>
        @enderror
        @error('confirmPassword')
        <div class="p-3 mb-2 bg-danger text-white">{{ $message }}</div>
        @enderror
        {{-- Errors --}}
        <form method="POST" action="{{ route('student.profile.passwordUpdate') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                <tr>
                    <th>Current Password <span class="text-danger">*</span></th>
                    <td><input required name="currentPassword" type="text" class="form-control" value="{{ old('currentPassword') }}"></td>
                </tr>
                <tr>
                    <th>New Password <span class="text-danger">*</span></th>
                    <td><input required name="newPassword" type="text" class="form-control" value="{{ old('newPassword') }}"></td>
                </tr><tr>
                    <th>Confirm New Password <span class="text-danger">*</span></th>
                    <td><input required name="confirmPassword" type="text" class="form-control" value="{{ old('confirmPassword') }}"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <input name="userid" type="hidden" value="{{ $user->id }}">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        </div>
    </div>



@section('scripts')

@endsection
@endsection