<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="author" content="@isset($HallOption) {{ $HallOption[0]->value }} @endisset" />
    <title>User Manual for JustEHall System - @isset($HallOption)
        {{ $HallOption[0]->value }}
    @endisset </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico')}}" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('css/lib/animate/animate.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-1 py-lg-0">
                <a href="{{route('root')}}" class="navbar-brand p-0">
                    <h1 class="m-0">@isset($HallOption) {{ $HallOption[8]->value }} @endisset</h1>
                    {{-- <img src="img/logo.png" alt="Logo"> --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="{{route('root')}}" class="nav-item nav-link">Home</a>
                         <a href="{{route('manual')}}" class="nav-item nav-link active">Manuals</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">My Account</a>
                            <div class="dropdown-menu m-0">
                                @auth
                                <a href="{{ route('student.dashboard') }}" class="dropdown-item">Dashboard</a>
                                @else
                                <a href="{{ route('login') }}" class="dropdown-item">Log in</a>
                                @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="dropdown-item">Register</a>
                                @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    @auth
                    <a href="{{ route('login') }}" class="btn rounded-pill py-1 px-4 ms-3 d-none d-lg-block">Login</a>
                    @else
                    <a href="{{ route('login') }}" class="btn rounded-pill py-1 px-4 ms-3 d-none d-lg-block">Login</a>
                    @endauth
                </div>
            </nav>
            <div class="container-xxl bg-primary hero-header">
                    <div class="container px-lg-2 py-2">
                        <div class="row g-2 align-items-end">
                            <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-2 animated slideInDown">User Manual</h1>
                            <p class="text-white pb-2 animated slideInDown">
                                User manual for the JustEHall system. If you have any further questions or need assistance, please feel free to contact our support team. Thank you for using JustEHall!</p>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img src="{{ asset('img/2_2k.jpg') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
        {{-- 1 --}}
        <div class="container-xxl py-5">
            <div class="container px-lg-2 py-2">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class=" mb-2 animated slideInDown">1.Registration</h1>
                            <p class=" pb-2 animated slideInDown">
                                To register on the JustEHall system, follow these steps: <br>
                                - Visit the JustEHall website.<br>
                                - Click on the My Account > "Register" button.<br>
                                - Fill out the registration form with your details, including name, email address, rollno , gender , and any other required information.<br>
                                - Choose a unique username and password for your account.<br>
                                - Click on the "Sign Up" button to create your account.<br>
                                
                                </p>
                    </div>
                    <div class="col-lg-6 text-center float-right">
                        <img src="{{ asset('img/registration.png') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        {{-- 2 --}}
        <div class="container py-5">
            <div class="container py-2 px-lg-2">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-6 text-center float-left">
                        <img src="{{ asset('img/login.webp') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                    </div>
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="mb-2 animated slideInDown">2.Login</h1>
                        <p class="pb-2 animated slideInDown">
                            Once you have registered, you can log in to your JustEHall account using the following steps:<br>
                                - Visit the JustEHall website.<br>
                                - Click on the My Account > "Login" button.<br>
                                - Enter your email or rollno and password in the respective fields.<br>
                                - Click on the "Login" button to access your account.<br>
                            </p>
                    </div>
                    
                </div>
            </div>
        </div>
        {{-- 3 --}}
        <div class="container-xxl py-5">
            <div class="container px-lg-2 py-2">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class=" mb-2 animated slideInDown">3. Room Allocation Application:</h1>
                        <p class=" pb-2 animated slideInDown"> To apply for room allocation, please follow these steps: <br>
                            - After logging in to your account, navigate to the Room > "New Room Request" section. <br>
                            - Fill out the room allocation application form with the required details and any other relevant information. <br>
                            - Click on the "Submit" or "Apply" button to send your room allocation application. <br>
                            </p>
                    </div>
                    <div class="col-lg-6 text-center float-right">
                        <img src="{{ asset('img/application.png') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        {{-- 4 --}}
        <div class="container py-5">
            <div class="container py-2 px-lg-2">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-6 text-center float-left">
                        <img src="{{ asset('img/payment.webp') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                    </div>
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="mb-2 animated slideInDown">4.Payment</h1>
                        <p class="pb-2 animated slideInDown">After your room allocation application is approved, you will receive a payment slip option for the application fees. Here's how to access your payment slip: <br>
                            - Log in to your JustEHall account. <br>
                            - Navigate to the Room Requests section. <br>
                            - O Room Room Request page find the add payment slip option and upload your reciept image <br>
                            </p>
                    </div>
                    
                </div>
            </div>
        </div>
        {{-- 5 --}}
        <div class="container-xxl py-5">
            <div class="container px-lg-2 py-2">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class=" mb-2 animated slideInDown">5. Food Order</h1>
                        <p class=" pb-2 animated slideInDown">
                            To place a food order through the JustEHall system, follow these steps (You need to be a resident of hall to avail this feature.): <br>
                            - Log in to your JustEHall account.<br>
                            - Navigate to the "Food Menu" section.<br>
                            - Browse the available menu options for that Food Time.<br>
                            - Select the items you wish to order and add quantity.<br>
                            - Click Place order. Once Order is placed money will be deducted from balance<br>
                            - You can also cancel order. Deadline to cancel - Previous day , 10 PM .<br>
                            </p>
                    </div>
                    <div class="col-lg-6 text-center float-right">
                        <img src="{{ asset('img/order.png') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        {{-- 6 --}}
        <footer class="py-5 bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s" >
            <div class="container px-4">
                <p class="m-0 text-center text-white">Copyright &copy; @isset($HallOption) {{ $HallOption[0]->value }} @endisset {{ date('Y') }}</a>, All Right Reserved.</p></div>
        </footer>


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('css/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('css/lib/easing/easing.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/mainHome.js') }}"></script>
</body>

</html>