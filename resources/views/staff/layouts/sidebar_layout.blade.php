<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('staff.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset($HallOption[3]->value) }}" class="rounded mx-auto d-block sidebar-card-illustration" alt="Logo" style="width:50%;">
        </div>
        <div class="sidebar-brand-text mx-3">Staff Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('staff.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    @if (Auth::guard('staff')->user()->type == 'provost')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Rooms
    </div>
    <!-- Nav Item Room Type - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('staff/roomtype*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseRoomType"
            aria-expanded="true" aria-controls="collapseRoomType">
            <i class="fas fa-fw fa-table"></i>
            <span>Room Type</span>
        </a>
        <div id="collapseRoomType" class="collapse @if(request()->is('staff/roomtype*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Room Type Management</h6>
                <a class="collapse-item" href="{{ route('staff.roomtype.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.roomtype.create') }}">Add new</a>
            </div>
        </div>
    </li>
<!-- Nav Item Room - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link @if(!request()->is('staff/rooms*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseRoom"
        aria-expanded="true" aria-controls="collapseRoom">
        <i class="fas fa-fw fa-table"></i>
        <span>Room</span>
    </a>
    <div id="collapseRoom" class="collapse @if(request()->is('staff/rooms*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Room Management</h6>
            <a class="collapse-item" href="{{ route('staff.rooms.index') }}">View All</a>
            <a class="collapse-item" href="{{ route('staff.rooms.create') }}">Add new</a>
        </div>
    </div>
</li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Staffs
    </div>

    <!-- Nav Item Staff - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('staff/staff*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseStaff"
            aria-expanded="true" aria-controls="collapseStaff">
            <i class="fas fa-fw fa-users"></i>
            <span>Staff</span>
        </a>
        <div id="collapseStaff" class="collapse @if(request()->is('staff/staff*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Staff Management</h6>
                <a class="collapse-item" href="{{ route('staff.staff.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.staff.create') }}">Add new</a>
            </div>
        </div>
    </li>
    @endif
    @if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Students System
    </div>

    <!-- Nav Item Customer - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('staff/student*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseStudent"
            aria-expanded="true" aria-controls="collapseStudent">
            <i class="fas fa-fw fa-users"></i>
            <span>Student</span>
        </a>
        <div id="collapseStudent" class="collapse @if(request()->is('staff/student*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Student Management</h6>
                <a class="collapse-item" href="{{ route('staff.student.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.student.create') }}">Add new</a>
            </div>
        </div>
    </li>
    <!-- Nav Item Customer - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('staff/roomallocation*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseStudentRoom"
            aria-expanded="true" aria-controls="collapseStudentRoom">
            <i class="fas fa-fw fa-users"></i>
            <span>Student Room Alocation</span>
        </a>
        <div id="collapseStudentRoom" class="collapse @if(request()->is('staff/roomallocation*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Student Room Alocation</h6>
                <a class="collapse-item" href="{{ route('staff.roomallocation.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.roomallocation.create') }}">Add new </a>
                <a class="collapse-item" href="{{ route('staff.roomallocation.roomrequests') }}">Allocation Requests </a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Food System
    </div>
    <!-- Nav FoodTime Services - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('staff/food*') || !request()->is('staff/foodtime*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-table"></i>
            <span>Food </span>
        </a>
        <div id="collapseSeven" class="collapse @if(request()->is('staff/food/*') || request()->is('staff/foodtime*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Food Management</h6>
                <a class="collapse-item" href="{{ route('staff.foodtime.index') }}"> Food Time </a>
                <a class="collapse-item" href="{{ route('staff.food.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.food.create') }}">Add new</a>
            </div>
        </div>
    </li>
  <!-- Divider -->
    @endif
    <hr class="sidebar-divider">
    @if (Auth::guard('staff')->user()->type == 'staff' || Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost')
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Orders System
    </div>
    <!-- Nav Item Support - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('staff/orders*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseEight"
            aria-expanded="true" aria-controls="collapseEight">
            <i class="fas fa-ticket-alt"></i>
            <span>Orders</span>
        </a>
        <div id="collapseEight" class="collapse @if(request()->is('staff/orders*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Order Management</h6>
                <a class="collapse-item" href="{{ route('staff.orders.index') }}">Orders</a>
                <a class="collapse-item" href="{{ route('staff.orders.scan') }}">Scan</a>
            </div>
        </div>
    </li>
     
   <hr class="sidebar-divider">
   @endif
   <!-- Heading -->
   <div class="sidebar-heading">
       Hall Balance System
   </div>
      <!-- Nav Item Payment - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link @if(!request()->is('staff/payment*') || !request()->is('staff/balance*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-credit-card"></i>
            <span>Payment</span>
        </a>
        <div id="collapseFour" class="collapse @if(request()->is('staff/payment*') || request()->is('staff/balance*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Payment Management</h6>
                <a class="collapse-item" href="{{ route('staff.payment.index') }}">View All Payment</a>
                <a class="collapse-item" href="{{ route('staff.payment.create') }}">Add new Payment</a>
                <a class="collapse-item" href="{{ route('staff.balance.index') }}">View Balances</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Support System
    </div>
    {{-- <!-- Nav Email Services - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('staff/email*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-table"></i>
            <span>Email Service</span>
        </a>
        <div id="collapseFive" class="collapse @if(request()->is('staff/email*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Email Management</h6>
                <a class="collapse-item" href="{{ route('staff.email.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.email.create') }}">Add new</a>
            </div>
        </div>
    </li> --}}
     <!-- Nav Item Support - Utilities Collapse Menu -->
     <li class="nav-item">
        <a class="nav-link @if (!request()->is('staff/support*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-ticket-alt"></i>
            <span>Support</span>
        </a>
        <div id="collapseOne" class="collapse @if(request()->is('staff/support*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Support Ticket Management</h6>
                <a class="collapse-item" href="{{ route('staff.support.index') }}">View Support Tickets</a>
            </div>
        </div>
    </li>
    @if (Auth::guard('staff')->user()->type == 'provost')
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Settings System
    </div>
    <!-- Nav Item Settings - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/settings*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSettings"
            aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-ticket-alt"></i>
            <span>Settings</span>
        </a>
        <div id="collapseSettings" class="collapse @if(request()->is('staff/settings*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Site Management</h6>
                <a class="collapse-item" href="{{ route('staff.settings.index') }}">View Settings</a>
                <a class="collapse-item" href="{{ route('staff.history.index') }}">View History</a>
            </div>
        </div>
    </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar - Logout - CopyRight) -->
    @include('../layouts/sidebar_toggle')
    <!-- End Sidebar Toggler (Sidebar - Logout - CopyRight) -->

    

</ul>