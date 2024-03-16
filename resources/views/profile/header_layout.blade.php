<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
      </button>
  <h6 class="sidebar-brand-text mt-2" > 
    @if (Auth::user()->hall_id!=0 && Auth::user()->hall_id!=null)
    {{ Auth::user()->hall->title }}
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

                        
                        <!-- Nav Item - Balance -->
                        @if(isset($dataBalance))
                        <div class="topbar-divider d-none d-sm-block "></div>
                        <li class="nav-item dropdown no-arrow mx-1">
                            @if ($dataBalance->balance_amount<0)
                            <a class="nav-link dropdown-toggle p-1 px-2 bg-danger text-white"
                            @else
                            <a class="nav-link dropdown-toggle p-1 px-2 bg-success text-white"
                            @endif
                             href="{{ route('student.balance.index') }}">
                                <i class="fas fa-wallet"> {{ $dataBalance->balance_amount }} ৳ </i></a>
                                
                        </li>
                        @endif
                        @if ($sorryRoomSidebar != 1)
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - Messages -->
                        @if(isset($dataMessage))
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                @if (Auth::user()->roomrequest!=null)
                                @if(Auth::user()->roomrequest->where('flag',0)->count())<span class="badge badge-danger badge-counter"> {{ Auth::user()->roomrequest->where('flag',0)->count() }} </span> @endif @endif
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                
                                @if(Auth::user()->roomrequest!=null)
                                @if(Auth::user()->roomrequest->count())
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('student.roomrequestshow')  }}">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('images/room.png') }}"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Room Application Submitted.</div>
                                        <div class="small text-gray-500">{{ Auth::user()->roomrequest->created_at->format('F j , Y') }}</div>
                                    </div>
                                </a>
                                @endif
                                @endif

                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>
                        @endif
                        @endif
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::user()->name }}
                                    
                                
                                </span>
                                <img class="img-profile rounded-circle"
                                @if (Auth::user()->photo!=null)
                                src="{{ asset('storage/'.Auth::user()->photo) }}"
                                @else
                                src="{{ asset('images/user.png') }}"
                                @endif
                                >
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('student.profile.view') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('student.profile.editPassword') }}">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->