<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
@if (Auth::guard('staff')->user()->hall!= null)
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('staff.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            @if (Auth::guard('staff')->user()->hall->logo == null)
            <img src="{{ asset($HallOption[3]->value) }}" class="rounded mx-auto d-block sidebar-card-illustration" alt="Logo" style="width:50%;">
            @else
            <img src="{{ asset('storage/'.Auth::guard('staff')->user()->hall->logo) }}" class="rounded mx-auto d-block sidebar-card-illustration" alt="Logo" style="width:50%;">
            @endif
        </div>
        <div class="sidebar-brand-text mx-3">Staff Panel</div>
    </a>
    
@endif
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('staff.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
@if (Auth::guard('staff')->user()->hall!= null && Auth::guard('staff')->user()->status != 0)
    @if (Auth::guard('staff')->user()->hall_id!=0 && Auth::guard('staff')->user()->hall_id!=null)
        @if (Auth::guard('staff')->user()->type == 'provost')
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Rooms
    </div>
<!-- Nav Item Room - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link @if(!request()->is('staff/rooms*') || !request()->is('staff/roomtype*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseRoom"
        aria-expanded="true" aria-controls="collapseRoom">
        <i class="fas fa-fw fa-hotel"></i>
        <span>Room</span>
    </a>
    <div id="collapseRoom" class="collapse @if(request()->is('staff/rooms*') || request()->is('staff/roomtype*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Room Management</h6>
            <a class="collapse-item" href="{{ route('staff.roomtype.index') }}">Room Types</a>
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
@if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost' || Auth::guard('staff')->user()->type == 'officer')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Students System
    </div>

    <!-- Nav Item Customer - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('staff/student*') || !request()->is('staff/balance*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseStudent"
            aria-expanded="true" aria-controls="collapseStudent">
            <i class="fas fa-fw fa-users"></i>
            <span>Student</span>
        </a>
        <div id="collapseStudent" class="collapse @if(request()->is('staff/student*') || request()->is('staff/balance*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Student Management</h6>
                <a class="collapse-item" href="{{ route('staff.student.index') }}">View All</a>
                @if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost')
                <a class="collapse-item" href="{{ route('staff.student.create') }}">Add new</a>
                <a class="collapse-item" href="{{ route('staff.balance.index') }}"><b>Balances</b></a>
                @endif
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
                @if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost')
                <a class="collapse-item" href="{{ route('staff.roomallocation.index') }}">View All</a>
                <a class="collapse-item" href="{{ route('staff.roomallocation.create') }}">Add new </a>
                @endif
                <a class="collapse-item" href="{{ route('staff.roomallocation.roomrequests') }}">Allocation Requests <span class="bg-danger text-white p-1 rounded">{{ App\Models\RoomRequest::all()->where('hall_id',Auth::guard('staff')->user()->hall_id)->where('flag',0)->count() }}</span> </a>
                <a class="collapse-item" href="{{ route('staff.roomallocation.issue') }}">Room Leave/Change <span class="bg-danger text-white p-1 rounded">{{ App\Models\RoomIssue::all()->where('hall_id',Auth::guard('staff')->user()->hall_id)->where('flag',0)->count() }}</span> </a>
            </div>
        </div>
    </li>
    @if (Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Food System
    </div>
    <!-- Nav FoodTime Services - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('staff/food*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-table"></i>
            <span>Food </span>
        </a>
        <div id="collapseSeven" class="collapse @if(request()->is('staff/food*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Food Management</h6>
                <a class="collapse-item" href="{{ route('staff.foodtime.index') }}"> Food Times </a>
                <a class="collapse-item" href="{{ route('staff.food.index') }}">View All Food</a>
                <a class="collapse-item" href="{{ route('staff.food.create') }}">Add new Food</a>
            </div>
        </div>
    </li>
    @endif
  <!-- Divider -->
    @endif
    <hr class="sidebar-divider">
    @if (Auth::guard('staff')->user()->type == 'staff' || Auth::guard('staff')->user()->type == 'provost' || Auth::guard('staff')->user()->type == 'aprovost' || Auth::guard('staff')->user()->type == 'officer')
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
        <a class="nav-link @if(!request()->is('staff/payment*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-credit-card"></i>
            <span>Payment</span>
        </a>
        <div id="collapseFour" class="collapse @if(request()->is('staff/payment*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Payment Management</h6>
                <a class="collapse-item" href="{{ route('staff.payment.index') }}">View All </a>
                <a class="collapse-item" href="{{ route('staff.payment.create') }}">Add new Payment</a>
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
    @if (Auth::guard('staff')->user()->type == 'provost')
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Settings System
    </div>
    <!-- Nav Item Settings - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('staff/settings*'))
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
@endif
    <!-- Sidebar Toggler (Sidebar - Logout - CopyRight) -->
    @include('../layouts/sidebar_toggle')
    <!-- End Sidebar Toggler (Sidebar - Logout - CopyRight) -->

    
    @endif
</ul>