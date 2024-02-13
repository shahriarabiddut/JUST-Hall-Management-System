<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="icon" type="image/x-icon" href="{{ asset($HallOption[4]->value) }}" />
    <meta name="author" content="">

    <title> Register | @isset($HallOption)
        {{ $HallOption[2]->value }}
    @endisset </title>
    <!-- Custom fonts for this template-->
    <link href="{{  asset('vendor/fontawesome-free/css/all.min.css')  }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

        <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body>

    <section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark" style="min-height: 100vh; background-size: cover; background-image: url('{{ asset($HallOption[5]->value) }}')">
        <div class="container-fluid">
          
          <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
            <div class="col-12 col-md-4 col-lg-4 h-50 ">
              <div class="card shadow">
                <div class="card-body mx-2">
                  @error('email')
                  <div class="text-bold bg-danger text-center text-white p-2">{{ $message }}</div>
                  @enderror
                  @error('gender')
                  <div class="text-bold bg-danger text-center text-white p-2">{{ $message }}</div>
                  @enderror
                  @error('rollno')
                  <div class="text-bold bg-danger text-center text-white p-2">{{ $message }}</div>
                  @enderror
                  @error('password')
                  <div class="text-bold bg-danger text-center text-white p-2">{{ $message }}</div>
                  @enderror
                  @error('dept')
                  <div class="text-bold bg-danger text-center text-white p-2">{{ $message }}</div>
                  @enderror
                  @error('session')
                  <div class="text-bold bg-danger text-center text-white p-2">{{ $message }}</div>
                  @enderror
                  <h4 class="card-title mt-3 text-center">Create An Account</h4>
                  
                  <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                      </div>
                      <input required name="name" class="form-control" placeholder="Full name" type="text" value="{{ old('name') }}">
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                      </div>
                      <select required name="gender" class="form-control room-list">
                        <option >--- Gender ---</option>
                        <option value="1"> Male </option>
                        <option value="0"> Female </option>
                    </select>
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-pen"></i> </span>
                      </div>
                      <input required name="dept" class="form-control" placeholder="Department - CSE , EEE" type="text" value="{{ old('dept') }}">
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-clock"></i> </span>
                      </div>
                      <input required name="session" class="form-control" placeholder="Example - 2017-18,2018-19" type="text" value="{{ old('session') }}">
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                      </div>
                      <input required name="rollno" class="form-control" placeholder="Enter Roll No" type="text" value="{{ old('rollno') }}">
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                      </div>
                      <input required name="email" class="form-control" placeholder="Email address" type="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                      </div>
                      <input required name="password" class="form-control" placeholder="Create password" type="password" value="{{ old('password') }}">
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                      </div>
                      <input required name="password_confirmation" class="form-control" placeholder="Repeat password" type="password" value="{{ old('password_confirmation') }}">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block"> Sign Up </button>
                    </div>
                    <hr>
                    <p class="text-center">Have an account ? 
                      <a href="{{ route('login') }}">Log In</a>
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
     </section>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    @yield('scripts')


</body>

</html>
