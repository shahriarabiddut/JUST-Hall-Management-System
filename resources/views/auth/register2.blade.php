<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/fav.png')}}" />
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
                                    <select required name="dept" class="form-control">
                                        <option selected value="0">Select Department</option>
                                        <option selected value="Computer Science and Engineering(CSE)">Computer Science and Engineering(CSE)</option>
                                        <option value="Electrical and Electronic Engineering(EEE)">Electrical and Electronic Engineering(EEE)
                                        </option>
                                        <option value="Industrial and Production Engineering(IPE)">Industrial and Production Engineering(IPE)
                                        </option>
                                        <option value="Petroleum and Mining Engineering(PME)">Petroleum and Mining Engineering(PME)</option>
                                        <option value="Chemical Engineering(ChE)">Chemical Engineering(ChE)</option>
                                        <option value="Biomedical Engineering(BE)">Biomedical Engineering(BE)</option>
                                        <option value="Textile Engineering(TE)">Textile Engineering(TE)</option>
                                        <option value="Agro Product Processing Technology">Agro Product Processing Technology</option>
                                        <option value="Climate and Disaster Management">Climate and Disaster Management</option>
                                        <option value="Environmental Science and Technology">Environmental Science and Technology</option>
                                        <option value="Nutrition and Food Technology">Nutrition and Food Technology</option>
                                        <option value="Fisheries and Marine Bioscience">Fisheries and Marine Bioscience</option>
                                        <option value="Genetic Engineering and Biotechnology">Genetic Engineering and Biotechnology</option>
                                        <option value="Microbiology">Microbiology</option>
                                        <option value="Pharmacy">Pharmacy</option>
                                        <option value="Nursing and Health Science">Nursing and Health Science</option>
                                        <option value="Physical Education and Sports Science">Physical Education and Sports Science</option>
                                        <option value="Physiotherapy and Rehabilitation">Physiotherapy and Rehabilitation</option>
                                        <option value="English">English</option>
                                        <option value="Chemistry">Chemistry</option>
                                        <option value="Mathematics">Mathematics</option>
                                        <option value="Physics">Physics</option>
                                        <option value="Accounting and Information Systems">Accounting and Information Systems</option>
                                        <option value="Finance and Banking">Finance and Banking</option>
                                        <option value="Management">Management</option>
                                        <option value="Marketing">Marketing</option>
                                        <!-- Add more departments here -->
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-clock"></i> </span>
                                      </div>
                                      <select required name="session" class="form-control">
                                        <option selected value="0"> -- Select Session -- </option>
                                        <option value="2017-18">2017-18</option>
                                        <option value="2018-19">2018-19</option>
                                        <option value="2019-20">2019-20</option>
                                        <option value="2020-21">2020-21</option>
                                        <option value="2021-22">2021-22</option>
                                        <option value="2022-23">2022-23</option>
                                        <option value="2023-24">2023-24</option>
                                    </select>
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