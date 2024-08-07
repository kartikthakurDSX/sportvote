<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('admin-dashboard')}}" class="brand-link">
      <!-- <img src="{{url('frontend/images/logo.png')}}" alt="SV Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">SPORTVOTE</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{url('frontend/profile_pic')}}/{{Auth::user()->profile_pic}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}
        <!-- Sidebar Menu -->
        <nav class="mt-2" id="navMenus">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <!-- <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard <i class="right fas fa-angle-left"></i> </p>
                    </a> -->
                    <a href="{{url('admin-dashboard')}}" class="nav-link ">
                        <i class="fa-brands fa-dochub"></i>
                        <p>Dashboard </p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="pages/widgets.html" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Widgets
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Bulk Upload
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('comp-bulk')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Competition</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('team-bulk')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Team</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('player-bulk')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Player</p>
                            </a>
                        </li>
                    </ul>
                </li>
                 <!-- <li class="nav-item">
                    <a href="{{url('sports')}}" class="nav-link">
                   <i class="fa-solid fa-basketball"></i>
                    <p>
                        Sports
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('admin-sport-attitude')}}" class="nav-link">
                   <i class="fa-solid fa-user-group"></i>
                    <p>
                        Sport Attitudes
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('admin-sport-levels')}}" class="nav-link">
                   <i class="fa-solid fa-turn-up"></i>
                    <p>
                        Sport Levels
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('admin.sport-stats')}}" class="nav-link">
                   <i class="fa-solid fa-file-lines"></i>
                    <p>
                        Sport Stats
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('admin-sport-ground-map')}}" class="nav-link">
                   <i class="fa-solid fa-road"></i>
                    <p>
                        Sport Ground Maps
                    </p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{url('admin-sport-ground-positions')}}" class="nav-link">
                   <i class="fa-solid fa-map-pin"></i>
                    <p>
                        Sport Ground Positions
                    </p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{url('admin-comp-report-type')}}" class="nav-link">
                   <i class="fa-solid fa-file-lines"></i>
                    <p>
                        Competition Report Types
                    </p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{url('admin-comp-subtype')}}" class="nav-link">
                   <i class="fa-solid fa-trophy"></i>
                    <p>
                        Competition Subtypes
                    </p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{url('admin-comp-type')}}" class="nav-link">
                   <i class="fa-solid fa-medal"></i>
                    <p>
                        Competition Types
                    </p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{url('admin-member-position')}}" class="nav-link">
                   <i class="fa-solid fa-people-roof"></i>
                    <p>
                        Member Positions
                    </p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="{{url('admin-notifty-modules')}}" class="nav-link">
                   <i class="fa-solid fa-bell"></i>
                    <p>
                        Notify Modules
                    </p>
                    </a>
                </li> -->

                <li class="nav-item">
            <a href="{{url('admin-logout')}}" class="nav-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <p>
                Logout
            </p>
            </a>
        </li>
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


