@extends('staff/layout')
@section('title', ' My Profile | Staff Dashboard')

@section('content')
<!-- Page Heading -->

    <div class="container py-5">
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
      <h1 class="border border-secondary rounded h3 mb-2 text-gray-800 p-2 bg-white"> My Profile </h1>
      

      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{$user->photo ? asset('storage/'.$user->photo) : url('images/user.png')}}" alt="User Photo" class="rounded-circle img-fluid" style="width: 150px;">
              <h5 class="my-3">{{ $user->name }}</h5>
              <p class="text-muted mb-4 text-justify">" {{ $user->bio }} "</p>
              
            </div>
          </div>
          
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Name</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $user->name }}</p>
                    </div>
                  </div>
                  <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Phone</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">+88 - {{ $user->phone }}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Address</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $user->address }}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3 float-left">
                  <a href="{{ route('staff.profile.edit') }}"><button type="button" class="btn btn-primary">Edit Profile</button></a>
                </div>
                
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>



@section('scripts')

@endsection
@endsection