<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="@isset($HallOption) {{ $HallOption[0]->value }} @endisset" />
        <title>Home - @isset($HallOption)
            {{ $HallOption[0]->value }}
        @endisset </title>
        <link rel="icon" type="image/x-icon" href="{{ asset($HallOption[4]->value) }}" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top" >
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand" href="#page-top">@isset($HallOption) {{ $HallOption[8]->value }} @endisset</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log in</a></li>

                        @if (Route::has('register'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-primary bg-gradient text-white" style="min-height: 80vh;">
            <div class="container px-4 text-center">
                <h1 class="fw-bolder">Welcome to @isset($HallOption) {{ $HallOption[8]->value }} @endisset</h1> <br>
                <img src="{{ asset('img/hall.jpeg') }}" style="max-height: 50vh" alt="Lab" class="img-fluid"><br><br>
            </div>
        </header>
        <!-- About section-->
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4"><p class="m-0 text-center text-white">Copyright &copy; @isset($HallOption)
                {{ $HallOption[0]->value }}
            @endisset {{ date('Y') }}</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>