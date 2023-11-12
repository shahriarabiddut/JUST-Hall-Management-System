<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset($HallOption[3]->value) }}" class="rounded mx-auto d-block sidebar-card-illustration" alt="Logo" style="width:50%;">
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Room System
    </div>

    <!-- Nav Item Room Type - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('admin/roomtype*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-hotel"></i>
            <span>Room Types</span>
        </a>
        <div id="collapseTwo" class="collapse @if(request()->is('admin/roomtype*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Room Type Management</h6>
                <a class="collapse-item" href="{{ route('admin.roomtype.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.roomtype.create') }}">Add new</a>
            </div>
        </div>
    </li>
    <!-- Nav Item Room - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('admin/rooms*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseRoom"
            aria-expanded="true" aria-controls="collapseRoom">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Room</span>
        </a>
        <div id="collapseRoom" class="collapse @if(request()->is('admin/rooms*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Room Management</h6>
                <a class="collapse-item" href="{{ route('admin.rooms.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.rooms.create') }}">Add new</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Students System
    </div>

    <!-- Nav Item Customer - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('admin/student*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-users"></i>
            <span>Student</span>
        </a>
        <div id="collapseThree" class="collapse @if(request()->is('admin/student*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Student Management</h6>
                <a class="collapse-item" href="{{ route('admin.student.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.student.create') }}">Add new </a>
                <a class="collapse-item" href="{{ route('admin.student.balances') }}"><b>Balances</b> </a>
            </div>
        </div>
    </li>
    <!-- Nav Item Customer - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('admin/roomallocation*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-users"></i>
            <span>Student Room Alocation</span>
        </a>
        <div id="collapseFour" class="collapse @if(request()->is('admin/roomallocation*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Student Room Alocation</h6>
                <a class="collapse-item" href="{{ route('admin.roomallocation.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.roomallocation.create') }}">Add new </a>
                <a class="collapse-item" href="{{ route('admin.roomallocation.roomrequests') }}">Allocation Requests </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Automation User System
    </div>
     <!-- Nav Item Department - Utilities Collapse Menu -->
     <li class="nav-item">
        <a class="nav-link @if (!request()->is('admin/department*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-fw fa-table"></i>
            <span>Staff Departments</span>
        </a>
        <div id="collapseFive" class="collapse @if(request()->is('admin/department*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Department Management</h6>
                <a class="collapse-item" href="{{ route('admin.department.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.department.create') }}">Add new</a>
            </div>
        </div>
    </li>
    <!-- Nav Item Staff - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('admin/staff*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSix"
            aria-expanded="true" aria-controls="collapseSix">
            <i class="fas fa-fw fa-users"></i>
            <span>Staff</span>
        </a>
        <div id="collapseSix" class="collapse @if(request()->is('admin/staff*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Staff Management</h6>
                <a class="collapse-item" href="{{ route('admin.staff.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.staff.create') }}">Add new</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Orders System
    </div>
    <!-- Nav Item Support - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('admin/orders*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseNine"
            aria-expanded="true" aria-controls="collapseNine">
            <i class="fas fa-ticket-alt"></i>
            <span>Orders</span>
        </a>
        <div id="collapseNine" class="collapse @if(request()->is('admin/orders*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Order Management</h6>
                <a class="collapse-item" href="{{ route('admin.orders.index') }}">Orders</a>
            </div>
        </div>
    </li>
   
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Email System
    </div>
    <!-- Nav Email Services - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('admin/email*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fa fa-envelope"></i>
            <span>Email Service</span>
        </a>
        <div id="collapseSeven" class="collapse @if(request()->is('admin/email*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Email Management</h6>
                <a class="collapse-item" href="{{ route('admin.email.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('admin.email.create') }}">Add new</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Support System
    </div>
    <!-- Nav Item Support - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/support*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseEight"
            aria-expanded="true" aria-controls="collapseEight">
            <i class="fas fa-ticket-alt"></i>
            <span>Support</span>
        </a>
        <div id="collapseEight" class="collapse @if(request()->is('student/support*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Support Ticket Management</h6>
                <a class="collapse-item" href="{{ route('admin.support.index') }}">View Support Tickets</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar - Logout - CopyRight) -->
    @include('../layouts/sidebar_toggle')
    <!-- End Sidebar Toggler (Sidebar - Logout - CopyRight) -->
    

    

</ul>