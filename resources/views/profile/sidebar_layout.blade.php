<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('student.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset($HallOption[3]->value) }}" class="rounded mx-auto d-block sidebar-card-illustration" alt="Logo" style="width:50%;">
        </div>
        <div class="sidebar-brand-text mx-3">Student Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('student.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Room Allocation
    </div>

    <!-- Nav Item Room - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('student/room*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-hotel"></i>
            <span>Room</span>
        </a>
        <div id="collapseTwo" class="collapse @if(request()->is('student/room*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Room </h6>
            @if(isset($sorryRoomSidebar))
                @if($sorryRoomSidebar)
                <a class="collapse-item" href="{{ route('student.myroom') }}">My Room Details</a> 
                @else
                <a class="collapse-item" href="{{ route('student.roomrequest') }}">New Room Request</a>
                <a class="collapse-item" href="{{ route('student.roomrequestshow') }}">My Room Requests</a>
                @endif
            @endif 
                
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Meal System
    </div>

    <!-- Nav Item Meal - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if(!request()->is('student/order*') || !request()->is('student/mealtoken*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-users"></i>
            <span>Meal</span>
        </a>
        <div id="collapseThree" class="collapse @if(request()->is('student/order*') || request()->is('student/mealtoken*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Oeder Food</h6>
                <a class="collapse-item" href="{{ route('student.order.foodmenu') }}">View Food Menu</a>
                <a class="collapse-item" href="{{ route('student.order.index') }}">Order History</a>
                <a class="collapse-item" href="{{ route('student.mealtoken.index') }}">Meal Token History</a>
            </div>
        </div>
    </li>
     

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Hall Balance System
    </div>
    <!-- Nav Item Balance - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/balance*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSix"
            aria-expanded="true" aria-controls="collapseSix">
            <i class="fas fa-wallet"></i>
            <span>Balance</span>
        </a>
        <div id="collapseSix" class="collapse @if(request()->is('student/balance*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Balance Management</h6>
                <a class="collapse-item" href="{{ route('student.balance.index') }}">My Balance </a>
            </div>
        </div>
    </li>
    <!-- Nav Item Payment - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/balance*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseEight"
            aria-expanded="true" aria-controls="collapseEight">
            <i class="fas fa-credit-card"></i>
            <span>Payments</span>
        </a>
        <div id="collapseEight" class="collapse @if(request()->is('student/payments*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Payment Management</h6>
                <a class="collapse-item" href="{{ route('student.payments.index') }}">View Payment History</a>
                <a class="collapse-item" href="{{ route('student.payments.create') }}">Add new prepayment</a>
            </div>
        </div>
    </li>
    <!-- Nav Item Support - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/support*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-ticket-alt"></i>
            <span>Support</span>
        </a>
        <div id="collapseSeven" class="collapse @if(request()->is('student/support*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Support Ticket Management</h6>
                <a class="collapse-item" href="{{ route('student.support.index') }}">View Support Tickets</a>
                <a class="collapse-item" href="{{ route('student.support.create') }}">Add New </a>
            </div>
        </div>
    </li>
   

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar - Logout - CopyRight) -->
    @include('../layouts/sidebar_toggle')
    <!-- End Sidebar Toggler (Sidebar - Logout - CopyRight) -->

    

</ul>
<!-- End of Sidebar -->