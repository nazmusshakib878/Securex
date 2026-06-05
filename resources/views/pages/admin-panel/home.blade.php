@extends("admin-panel")

@section("content")
<main class="ops-dashboard">
    <div class="ops-titlebar">
        <div>
            <div class="page-header-kicker">Admin Workspace</div>
            <h2 class="h3 mb-1">Securex Control Room</h2>
            <p class="text-muted mb-0">A quick view of bookings, service activity and visitor messages.</p>
        </div>
        <div class="ops-title-actions">
            <a href="{{ route('viewServiceAddForm') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Service
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-globe me-1"></i>View Site
            </a>
        </div>
    </div>

    <div class="ops-layout">
        <section class="ops-main">
            <div class="ops-summary">
                <div class="ops-summary-copy">
                    <span>Today Focus</span>
                    <h3>{{ $pendingBookings }} booking requests need review</h3>
                    <p>Keep new requests moving and check visitor messages before updating service listings.</p>
                </div>
                <div class="ops-summary-actions">
                        <a href="{{ route('admin.bookings') }}">Open inbox</a>
                </div>
            </div>

            <div class="ops-section-card">
                <div class="ops-section-head">
                    <div>
                        <div class="page-header-kicker">Bookings</div>
                        <h5 class="mb-0">Latest Requests</h5>
                    </div>
                    <span>{{ $totalBookings }} total</span>
                </div>

                <div class="ops-table">
                    @forelse($recentBookings as $booking)
                        <div class="ops-table-row">
                            <div class="ops-person">
                                <div class="ops-avatar">{{ strtoupper(substr($booking->name, 0, 1)) }}</div>
                                <div>
                                    <strong>{{ $booking->name }}</strong>
                                    <small>{{ $booking->email }}</small>
                                </div>
                            </div>
                            <div class="ops-service">{{ $booking->service->title ?? 'N/A' }}</div>
                            <span class="badge bg-warning text-dark">{{ ucfirst($booking->status) }}</span>
                            <small class="text-muted text-end">{{ $booking->created_at->format('M d, Y') }}</small>
                        </div>
                    @empty
                        <div class="empty-dashboard-state">No bookings yet.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <aside class="ops-side">
            <div class="ops-stat-panel">
                <div class="ops-stat-item">
                    <span>Total Users</span>
                    <strong>{{ $totalUsers }}</strong>
                    <i class="bi bi-people"></i>
                </div>
                <div class="ops-stat-item">
                    <span>Active Services</span>
                    <strong>{{ $activeServices }}</strong>
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="ops-stat-item">
                    <span>Messages</span>
                    <strong>{{ $contactMessages }}</strong>
                    <i class="bi bi-envelope"></i>
                </div>
            </div>

            <div class="ops-section-card">
                <div class="ops-section-head">
                    <div>
                        <div class="page-header-kicker">Inbox</div>
                        <h5 class="mb-0">Recent Booking</h5>
                    </div>
                    <a href="{{ route('admin.bookings') }}">View</a>
                </div>

                <div class="ops-message-list">
                    @forelse($recentContactMessages as $message)
                        <div class="ops-message">
                            <strong>{{ $message->subject }}</strong>
                            <span>{{ $message->name }} - {{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="empty-dashboard-state">No booking requests yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="ops-shortcuts">
                <a href="{{ route('adminUsers') }}"><i class="bi bi-people"></i>Users</a>
                <a href="{{ route('viewServiceList') }}"><i class="bi bi-card-list"></i>Services</a>
            </div>
        </aside>
    </div>
</main>
@endsection
