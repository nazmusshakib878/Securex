@extends("admin-panel")

@section("content")
<main class="dashboard-shell">
    <section class="dashboard-hero mb-4">
        <div class="dashboard-hero-copy">
            <div class="page-header-kicker text-white-50">Command Desk</div>
            <h2 class="display-6 fw-bold mb-2">Welcome, {{ Auth::user()->name ?? 'Admin' }}</h2>
            <p class="mb-0">Review bookings, messages, users and services from a cleaner admin workspace.</p>
        </div>
        <div class="dashboard-hero-actions">
            <a href="{{ route('viewServiceAddForm') }}" class="btn btn-light text-primary fw-semibold">
                <i class="bi bi-plus-lg me-1"></i>Add Service
            </a>
            <a href="{{ route('contactMessages') }}" class="btn btn-outline-light">
                <i class="bi bi-envelope me-1"></i>Messages
            </a>
        </div>
    </section>

    <section class="dashboard-metrics mb-4">
        <article class="metric-tile metric-blue">
            <div class="metric-icon"><i class="bi bi-people-fill"></i></div>
            <div>
                <span>Total Users</span>
                <strong>{{ $totalUsers }}</strong>
                <small>Registered accounts</small>
            </div>
        </article>
        <article class="metric-tile metric-green">
            <div class="metric-icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <span>Active Services</span>
                <strong>{{ $activeServices }}</strong>
                <small>Visible to visitors</small>
            </div>
        </article>
        <article class="metric-tile metric-orange">
            <div class="metric-icon"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <span>Pending Bookings</span>
                <strong>{{ $pendingBookings }}</strong>
                <small>Waiting for review</small>
            </div>
        </article>
        <article class="metric-tile metric-purple">
            <div class="metric-icon"><i class="bi bi-chat-left-text-fill"></i></div>
            <div>
                <span>Contact Messages</span>
                <strong>{{ $contactMessages }}</strong>
                <small>Website enquiries</small>
            </div>
        </article>
    </section>

    <div class="row g-4 align-items-stretch mb-4">
        <div class="col-12 col-xl-7">
            <section class="card h-100 dashboard-focus-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                        <div>
                            <div class="page-header-kicker">Booking Queue</div>
                            <h5 class="card-title mb-1">Recent Requests</h5>
                            <p class="text-muted mb-0">Latest service booking submissions.</p>
                        </div>
                        <span class="dashboard-count-badge">{{ $totalBookings }} Total</span>
                    </div>

                    <div class="dashboard-booking-list">
                        @forelse($recentBookings as $booking)
                            <div class="booking-row">
                                <div class="booking-avatar">{{ strtoupper(substr($booking->name, 0, 1)) }}</div>
                                <div class="booking-main">
                                    <strong>{{ $booking->name }}</strong>
                                    <span>{{ $booking->email }}</span>
                                </div>
                                <div class="booking-service">{{ $booking->service->title ?? 'N/A' }}</div>
                                <span class="badge bg-warning text-dark">{{ ucfirst($booking->status) }}</span>
                                <small class="text-muted">{{ $booking->created_at->format('M d') }}</small>
                            </div>
                        @empty
                            <div class="empty-dashboard-state">No bookings yet.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <div class="col-12 col-xl-5">
            <section class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                        <div>
                            <div class="page-header-kicker">Inbox</div>
                            <h5 class="card-title mb-1">Recent Contact</h5>
                            <p class="text-muted mb-0">Fresh messages from visitors.</p>
                        </div>
                        <a href="{{ route('contactMessages') }}" class="btn btn-outline-primary btn-sm">Open</a>
                    </div>

                    <div class="message-stack">
                        @forelse($recentContactMessages as $message)
                            <div class="message-note">
                                <div class="d-flex justify-content-between gap-3">
                                    <strong>{{ $message->subject }}</strong>
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                                <span>{{ $message->name }}</span>
                            </div>
                        @empty
                            <div class="empty-dashboard-state">No contact messages yet.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>

    <section class="dashboard-shortcuts">
        <a href="{{ route('viewServiceList') }}" class="shortcut-link">
            <i class="bi bi-card-list"></i>
            <span>Manage services</span>
        </a>
        <a href="{{ route('adminUsers') }}" class="shortcut-link">
            <i class="bi bi-people"></i>
            <span>View users</span>
        </a>
        <a href="{{ route('home') }}" class="shortcut-link">
            <i class="bi bi-globe"></i>
            <span>Visit website</span>
        </a>
    </section>
</main>
@endsection
