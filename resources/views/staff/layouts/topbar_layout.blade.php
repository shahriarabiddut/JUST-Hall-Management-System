<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" onclick="toggleSidebaar()" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
        </button>
    <h6 class="sidebar-brand-text mt-2" > 
    @if (Auth::guard('staff')->user()->hall_id!=0 && Auth::guard('staff')->user()->hall_id!=null)
        {{ Auth::guard('staff')->user()->hall->title }}
    @else
        @isset($HallOption) {{ $HallOption[2]->value }} @endisset
    @endif
    </h6>

    
    <script>
        if (/Mobi/.test(navigator.userAgent)) {
            window.onload = function () {
            let myDiv = document.getElementById('sidebarToggleTop');
            myDiv.click();
        };
        }
    </script>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::guard('staff')->user()->name }}
                
                </span>
                <img class="img-profile rounded-circle"
                src="{{Auth::guard('staff')->user()->photo ? asset('storage/'.Auth::guard('staff')->user()->photo) : url('images/user.png')}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('staff.profile.view') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('staff.profile.editPassword') }}">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Change Password 
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('staff.logout') }}" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>