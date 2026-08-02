<nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
            <a href="{{ route('home') }}" class="navbar-brand p-0">
                <h1 class="m-0"><i class="fa fa-user-tie me-2"></i>Startup</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                    <a href="{{ route('home') }}#services" class="nav-item nav-link">Services</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ route('home') }}#features" class="dropdown-item">Our features</a>
                            <a href="{{ route('home') }}#team" class="dropdown-item">Team Members</a>
                            <a href="{{ route('home') }}#testimonials" class="dropdown-item">Testimonial</a>
                            <a href="{{ route('home') }}#quote" class="dropdown-item">Free Quote</a>
                        </div>
                    </div>
                    <a href="{{ route('home') }}#booking" class="nav-item nav-link">Booking</a>
                </div>
                <button type="button" class="btn text-primary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
                @if(Auth::user())
                    @if(Auth::user()->isAdmin)
                        <a href="{{ route('viewAdminPanel') }}" class="btn btn-primary py-2 px-4 ms-3">Dashboard</a>
                    @else
                        <a href="{{ route('user.bookings') }}" class="btn btn-primary py-2 px-4 ms-3">My Bookings</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="d-inline ms-3">
                        @csrf
                        <button type="submit" class="btn btn-danger py-2 px-4">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4 ms-3">Login</a>
                    <a href="{{ route('viewSignup') }}" class="btn btn-outline-primary py-2 px-4 ms-3">Sign Up</a>
                @endif
            </div>
        </nav>
