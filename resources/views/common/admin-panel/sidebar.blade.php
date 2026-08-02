<nav id="sidebarMenu" class="text-white p-3 d-flex flex-column">
            <div class="d-flex align-items-center mb-4">
                <div class="brand-mark me-3">
                    <i class="bi bi-shield-check text-white fs-5"></i>
                </div>
                <div>
                    <div class="fs-5 fw-bold">Securex</div>
                    <small class="text-white-50">Control center</small>
                </div>
                <button class="btn btn-sm btn-outline-light ms-auto d-lg-none" id="sidebarCloseBtn" type="button">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <p class="text-white-50 small mb-3">Manage users, services, bookings and website messages.</p>
            <div class="sidebar-quick-card">
                <span>Workspace</span>
                <strong>Security Service Admin</strong>
            </div>

            <div class="sidebar-menu-label">Overview</div>
            <ul class="nav nav-pills flex-column admin-sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('viewAdminPanel') ? 'active' : '' }}" aria-current="page" href="{{ route('viewAdminPanel') }}">
                        <span class="nav-index">01</span>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-menu-label">Services</div>
            <ul class="nav nav-pills flex-column admin-sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('viewServiceList', 'viewServiceEditForm') ? 'active' : '' }}" aria-current="page" href="{{ route('viewServiceList') }}">
                        <span class="nav-index">02</span>
                        <span>Service List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('viewServiceAddForm') ? 'active' : '' }}" aria-current="page" href="{{ route('viewServiceAddForm') }}">
                        <span class="nav-index">03</span>
                        <span>Add Service</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-menu-label">Operations</div>
            <ul class="nav nav-pills flex-column mb-4 admin-sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('adminUsers') ? 'active' : '' }}" href="{{ route('adminUsers') }}">
                        <span class="nav-index">04</span>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}" href="{{ route('admin.bookings') }}">
                        <span class="nav-index">05</span>
                        <span>Booking Requests</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <button type="submit" class="nav-link nav-link-logout border-0 bg-transparent w-100">
                        <span class="nav-index"><i class="bi bi-box-arrow-right"></i></span>
                        <span>Logout</span>
                    </button>
                    </form>
                </li>
            </ul>
            <div class="mt-auto pt-3 border-top border-secondary">
                <div class="d-flex align-items-center">
                    <div class="me-3 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin User' }}</div>
                        <small class="text-white-50">Administrator</small>
                    </div>
                </div>
            </div>
        </nav>
