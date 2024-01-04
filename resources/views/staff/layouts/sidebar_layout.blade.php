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

    <hr class="sidebar-divider">
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
     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading">
         Hall Food System
     </div>
     <!-- Nav FoodTime Services - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link @if (!request()->is('staff/foodtime*'))
             collapsed
         @endif" href="#" data-toggle="collapse" data-target="#collapseSix"
             aria-expanded="true" aria-controls="collapseSix">
             <i class="fas fa-table"></i>
             <span>FoodTime </span>
         </a>
         <div id="collapseSix" class="collapse @if(request()->is('staff/foodtime*')) show @endif" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">FoodTime Management</h6>
                 <a class="collapse-item" href="{{ route('staff.foodtime.index') }}">View All</a>
                 <a class="collapse-item" href="{{ route('staff.foodtime.create') }}">Add new</a>
             </div>
         </div>
     </li>
     <!-- Nav FoodTime Services - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link @if (!request()->is('staff/food*'))
             collapsed
         @endif" href="#" data-toggle="collapse" data-target="#collapseSeven"
             aria-expanded="true" aria-controls="collapseSeven">
             <i class="fas fa-table"></i>
             <span>Food Items </span>
         </a>
         <div id="collapseSeven" class="collapse @if(request()->is('staff/food/*')) show @endif" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Food Item Management</h6>
                 <a class="collapse-item" href="{{ route('staff.food.index') }}">View All</a>
                 <a class="collapse-item" href="{{ route('staff.food.create') }}">Add new</a>
             </div>
         </div>
     </li>
   <!-- Divider -->
   <hr class="sidebar-divider">
   <!-- Heading -->
   <div class="sidebar-heading">
       Hall Balance System
   </div>

   <!-- Nav Item Balance - Pages Collapse Menu -->
   <li class="nav-item">
       <a class="nav-link @if(!request()->is('staff/balance*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
           <i class="fas fa-wallet"></i>
           <span>Balance</span>
       </a>
       <div id="collapseTwo" class="collapse @if(request()->is('staff/balance*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
           <div class="bg-white py-2 collapse-inner rounded">
               <h6 class="collapse-header">Balance Management</h6>
               <a class="collapse-item" href="{{ route('staff.balance.index') }}">View All </a>
               {{-- <a class="collapse-item" href="{{ route('staff.balance.create') }}">Add new Customer</a> --}}
           </div>
       </div>
   </li>
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
                <a class="collapse-item" href="{{ route('staff.payment.index') }}">View All Payment</a>
                <a class="collapse-item" href="{{ route('staff.payment.create') }}">Add new Payment</a>
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
    </li>
     <!-- Nav Item Support - Utilities Collapse Menu -->
     <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/support*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-ticket-alt"></i>
            <span>Support</span>
        </a>
        <div id="collapseOne" class="collapse @if(request()->is('student/support*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Support Ticket Management</h6>
                <a class="collapse-item" href="{{ route('staff.support.index') }}">View Support Tickets</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item BackupUpdate - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link @if (!request()->is('student/support*'))
            collapsed
        @endif" href="#" data-toggle="collapse" data-target="#collapseOneOne"
            aria-expanded="true" aria-controls="collapseOneOne">
            <i class="fas fa-ticket-alt"></i>
            <span>Backup Update</span>
        </a>
        <div id="collapseOneOne" class="collapse @if(request()->is('student/backup*')) show @endif" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Backup Update Management</h6>
                <a class="collapse-item" href="{{ route('staff.support.index') }}">Backup</a>
                <a class="collapse-item" href="{{ route('staff.support.index') }}">Update</a>
            </div>
        </div>
    </li>
   

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar - Logout - CopyRight) -->
    @include('../layouts/sidebar_toggle')
    <!-- End Sidebar Toggler (Sidebar - Logout - CopyRight) -->

    

</ul>