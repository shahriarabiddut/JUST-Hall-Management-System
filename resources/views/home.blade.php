<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="author" content="@isset($HallOption) {{ $HallOption[0]->value }} @endisset" />
    <title>Home - @isset($HallOption)
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
                        <a href="{{route('root')}}" class="nav-item nav-link active">Home</a>
                           <a href="{{route('manual')}}" class="nav-item nav-link ">Manuals</a>
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
                <div class="container px-lg-5">
                    <div class="row g-5 align-items-end">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-2 animated slideInDown">Just Hall Automation System</h1>
                            <p class="text-white pb-2 animated slideInDown">The traditional manual processes in halls can be time-consuming, prone to errors and often result in poor coordination and management. The System is a solution that aims to streamline and automate various hall management processes, resulting in improved efficiency, reduced workload, and better overall experience for hall residents. </p>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img src="{{ asset('img/2_2k.jpg') }}" style="max-height: 50vh" alt="Lab" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Feature Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="feature-item bg-light rounded text-center p-4">
                            <i class="fa fa-3x fa-mail-bulk text-primary mb-4"></i>
                            <h5 class="mb-3">Room Allocation</h5>
                            <p class="m-0">Room Allocation Management and Application for Students to keep Records of Room Allocation.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-light rounded text-center p-4">
                            <i class="fa fa-3x fa-search text-primary mb-4"></i>
                            <h5 class="mb-3">Order Food</h5>
                            <p class="m-0">Hall Residents can order food from system.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-light rounded text-center p-4">
                            <i class="fa fa-3x fa-laptop-code text-primary mb-4"></i>
                            <h5 class="mb-3">Hall Support</h5>
                            <p class="m-0">Hall Support system for students to get support from their respective halls.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->
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