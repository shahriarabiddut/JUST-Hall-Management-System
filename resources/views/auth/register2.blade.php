<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico')}}" />
    <meta name="author" content="">

    <title> Register | @isset($HallOption) {{ $HallOption[2]->value }} @endisset </title>
    <!-- Custom fonts for this template-->
    <link href="{{  asset('vendor/fontawesome-free/css/all.min.css')  }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

        <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-info">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <p class="text-danger"> {{ $error }} </p>
                        @endforeach
                        @endif
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form onsubmit="handleSubmit(event)"  class="user" method="POST" action="{{ route('register') }}" >
                                @csrf
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                      </div>
                                      <input required name="name" class="form-control form-control-user" placeholder="Enter Full name" type="text" value="{{ old('name') }}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-users"></i> </span>
                                      </div>
                                      <select required name="gender" class="form-control ">
                                        <option value="3">--- Select Gender ---</option>
                                        <option value="1"> Male </option>
                                        <option value="0"> Female </option>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-pen"></i> </span>
                                    </div>
                                    <input required name="dept" class="form-control form-control-user" placeholder="Department - CSE , EEE" type="text" value="{{ old('dept') }}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-clock"></i> </span>
                                      </div>
                                      <input required name="session" class="form-control form-control-user" placeholder="Session - 2017-18,2018-19" type="text" value="{{ old('session') }}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-id-badge"></i> </span>
                                    </div>
                                    <input required name="rollno" class="form-control form-control-user" placeholder="Enter Roll No - 123456 , MS-123456" type="text" value="{{ old('rollno') }}">
                                </div>
                                
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                    </div>
                                    <input type="email" name="email" required class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" value="{{ old('email') }}">
                                </div>
                                <div class="form-group row ">
                                    <div class="col-sm-6 mb-3 mb-sm-0 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                          </div>
                                          <input required name="password" class="form-control form-control-user" placeholder="Create password" type="password" value="{{ old('password') }}">
                                    </div>
                                    <div class="col-sm-6 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input type="password" class="form-control form-control-user"
                                        required name="password_confirmation" id="exampleRepeatPassword" placeholder="Repeat Password" value="{{ old('password_confirmation') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block"> Sign Up </button>
                                </div>
                                <hr>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="btn btn-google btn-user btn-block"> Forgot Password?
                                </a>
                                @endif
                            </form>
                            <hr>
                            <div class="text-center">
                                Have an account ? <a class="btn btn-facebook btn-user btn-block" href="{{ route('login') }}">Log In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
@include('../layouts/validateinput')
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>