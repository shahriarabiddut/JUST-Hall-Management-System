<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
<!--Logout - Dashboard -->
<hr class="sidebar-divider d-none d-md-block">
<li class="nav-item active">
    @auth
    <a class="nav-link" href="{{ route('logout') }}">
    @endauth
    @auth('staff')
    <a class="nav-link" href="{{ route('staff.logout') }}">
    @endauth
    @auth('admin')
    <a class="nav-link" href="{{ route('admin.logout') }}">
    @endauth
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span></a>
</li>
<hr class="sidebar-divider d-none d-md-block">
<!-- Sidebar Message -->
<div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="{{ asset('img/just.jpg') }}" alt="...">
    <p class="text-center mb-2">@isset($HallOption) {{ $HallOption[2]->value }} @endisset</p>
    <a class="btn btn-success btn-sm" href="#">JUST CSE</a>
</div>