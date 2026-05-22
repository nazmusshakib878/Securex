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
            <hr class="border-secondary">
            <ul class="nav nav-pills flex-column mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('viewAdminPanel') ? 'active' : '' }}" aria-current="page" href="{{ route('viewAdminPanel') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('viewServiceAddForm') ? 'active' : '' }}" aria-current="page" href="{{ route('viewServiceAddForm') }}"><i class="bi bi-plus-circle"></i>Add Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('viewServiceList', 'viewServiceEditForm') ? 'active' : '' }}" aria-current="page" href="{{ route('viewServiceList') }}"><i class="bi bi-card-list"></i>Service List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contactMessages') ? 'active' : '' }}" href="{{ route('contactMessages') }}"><i class="bi bi-envelope"></i>Contact Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('adminUsers') ? 'active' : '' }}" href="{{ route('adminUsers') }}"><i class="bi bi-people"></i>Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i>Logout</a>
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
