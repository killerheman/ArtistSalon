<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('frontend/assets/images/cmlogo.png') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('frontend/assets/images/cmlogo.png') }}" alt="" height="80"></span>
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <!-- Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}" role="button" aria-expanded="false">
                        <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <!-- User Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.user.index') }}" role="button" aria-expanded="false">
                        <i data-feather="users" class="icon-dual"></i> <span data-key="t-dashboards">User</span>
                    </a>
                </li>

                <!-- Role/Permission Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i data-feather="lock" class="icon-dual"></i> <span data-key="t-dashboards">Roles/Permission</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards1">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.role.index')}}" class="nav-link" data-key="t-analytics"> Role </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.permission.index')}}" class="nav-link" data-key="t-analytics">Permission</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.rolePermission')}}" class="nav-link" data-key="t-analytics">Role has permission</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Gallery Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.gallery.index') }}" role="button" aria-expanded="false">
                        <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Gallery</span>
                    </a>
                </li>

                <!-- Blog Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.blog.index') }}" role="button" aria-expanded="false">
                        <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Blog</span>
                    </a>
                </li>

                <!-- Services Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.services.index') }}" role="button" aria-expanded="false">
                        <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Services</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>