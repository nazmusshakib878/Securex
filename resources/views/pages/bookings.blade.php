@php
    $siteAsset = asset('site');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Securex - My Bookings</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="{{ asset('favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ $siteAsset }}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ $siteAsset }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ $siteAsset }}/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="{{ $siteAsset }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ $siteAsset }}/css/style.css" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')

    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
    </div>

    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 px-4 px-lg-5">
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
            <h2 class="m-0 text-primary">Securex</h2>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-4 py-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
                <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                <a href="{{ route('home') }}#services" class="nav-item nav-link">Service</a>
                <a href="{{ route('home') }}#projects" class="nav-item nav-link">Project</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                        <a href="{{ route('home') }}#features" class="dropdown-item">Feature</a>
                        <a href="{{ route('home') }}#quote" class="dropdown-item">Free Quote</a>
                        <a href="{{ route('home') }}#team" class="dropdown-item">Our Team</a>
                        <a href="{{ route('home') }}#testimonials" class="dropdown-item">Testimonial</a>
                    </div>
                </div>
                <a href="{{ route('home') }}#booking" class="nav-item nav-link">Booking</a>
            </div>
            <div class="h-100 d-lg-inline-flex align-items-center gap-2">
                @auth
                    @if(Auth::user()->isAdmin)
                        <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ route('viewAdminPanel') }}">Dashboard</a>
                    @else
                        <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ route('user.bookings') }}">My Bookings</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-danger rounded-pill py-2 px-4" type="submit">Logout</button>
                    </form>
                @else
                    <a class="btn btn-outline-primary rounded-pill py-2 px-4" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ route('viewSignup') }}">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center">
                <div class="bg-primary mb-3 mx-auto" style="width: 60px; height: 2px;"></div>
                <h1 class="display-5 mb-5">My Bookings</h1>
                <p class="mb-4">View your submitted booking requests and current status here.</p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                @php
                                    $displayStatus = $booking->status === 'approved' ? 'accepted' : $booking->status;
                                    $statusBadge = $booking->status === 'pending' ? 'warning text-dark' : ($booking->status === 'approved' || $booking->status === 'accepted' ? 'success' : ($booking->status === 'rejected' ? 'danger' : ($booking->status === 'completed' ? 'info text-dark' : 'secondary')));
                                @endphp
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->service->title ?? 'N/A' }}</td>
                                <td>${{ number_format($booking->service_price, 2) }}</td>
                                <td>{{ optional($booking->booking_date)->format('M d, Y') ?? '-' }}</td>
                                <td>{{ $booking->time_slot ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusBadge }}">
                                        {{ ucfirst($displayStatus) }}
                                    </span>
                                </td>
                                <td>{{ Illuminate\Support\Str::limit($booking->message ?? '-', 80) }}</td>
                                <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($booking->status === 'completed')
                                        <a href="{{ route('bookings.invoice', $booking) }}" class="btn btn-sm btn-primary">View Invoice</a>
                                    @elseif($booking->status !== 'canceled')
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Canceled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">You have no bookings yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-secondary footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Services</h5>
                    <a class="btn btn-link" href="">Business Security</a>
                    <a class="btn btn-link" href="">Fire Detection</a>
                    <a class="btn btn-link" href="">Alarm Systems</a>
                    <a class="btn btn-link" href="">CCTV & Video</a>
                    <a class="btn btn-link" href="">Smart Home</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="{{ route('home') }}">Home</a>
                    <a class="btn btn-link" href="{{ route('about') }}">About</a>
                    <a class="btn btn-link" href="{{ route('home') }}#services">Services</a>
                    <a class="btn btn-link" href="{{ route('home') }}#booking">Booking</a>
                    <a class="btn btn-link" href="{{ route('login') }}">Login</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-transparent border-secondary w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ $siteAsset }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ $siteAsset }}/lib/wow/wow.min.js"></script>
    <script src="{{ $siteAsset }}/lib/easing/easing.min.js"></script>
    <script src="{{ $siteAsset }}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{ $siteAsset }}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{ $siteAsset }}/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="{{ $siteAsset }}/lib/lightbox/js/lightbox.min.js"></script>
    <script src="{{ $siteAsset }}/js/main.js"></script>
</body>

</html>
