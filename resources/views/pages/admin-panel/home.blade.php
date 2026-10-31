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
            <a href="{{ route('contactMessages') }}" class="btn btn-outline-secondary">
                <i class="bi bi-envelope me-1"></i>View Messages ({{ $contactMessages }})
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
                    <a href="{{ route('admin.bookings') }}"><i class="bi bi-calendar-check me-1"></i>Review Bookings</a>
                </div>
            </div>

            <div class="ops-section-card">
                <div class="ops-section-head">
                    <div>
                        <div class="page-header-kicker">Bookings</div>
                        <h5 class="mb-0">Latest Requests</h5>
                    </div>
                    <a href="{{ route('admin.bookings') }}" class="text-decoration-none fw-semibold small">{{ $totalBookings }} total &rarr;</a>
                </div>

                <div class="ops-table">
                    @forelse($recentBookings as $booking)
                        @php
                            $statusBadge = match($booking->status) {
                                'pending' => 'warning text-dark',
                                'accepted', 'approved' => 'success text-white',
                                'completed' => 'info text-dark',
                                'rejected' => 'danger text-white',
                                'canceled' => 'secondary text-white',
                                default => 'secondary text-white'
                            };
                        @endphp
                        <div class="ops-table-row">
                            <div class="ops-person">
                                <div class="ops-avatar">{{ strtoupper(substr($booking->name, 0, 1)) }}</div>
                                <div>
                                    <strong>{{ $booking->name }}</strong>
                                    <small>{{ $booking->email }}</small>
                                </div>
                            </div>
                            <div class="ops-service">{{ $booking->service->title ?? 'N/A' }}</div>
                            <span class="badge bg-{{ $statusBadge }}">{{ ucfirst($booking->status) }}</span>
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
                        <h5 class="mb-0">Recent Messages</h5>
                    </div>
                    <a href="{{ route('contactMessages') }}">View All</a>
                </div>

                <div class="ops-message-list">
                    @forelse($recentContactMessages as $message)
                        <div class="ops-message">
                            <div class="d-flex justify-content-between align-items-baseline mb-1">
                                <strong class="text-dark">{{ $message->name }}</strong>
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="small text-primary fw-semibold mb-1">{{ $message->service->title ?? 'General Inquiry' }} &bull; <span class="text-muted">{{ $message->subject }}</span></div>
                            <span class="text-muted small">{{ \Illuminate\Support\Str::limit($message->message, 65) }}</span>
                        </div>
                    @empty
                        <div class="empty-dashboard-state">No inquiries yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="ops-shortcuts">
                <a href="{{ route('adminUsers') }}"><i class="bi bi-people"></i>Users</a>
                <a href="{{ route('viewServiceList') }}"><i class="bi bi-card-list"></i>Services</a>
                <a href="{{ route('admin.bookings') }}"><i class="bi bi-calendar-check"></i>Bookings</a>
                <a href="{{ route('contactMessages') }}"><i class="bi bi-envelope"></i>Messages</a>
            </div>
        </aside>
    </div>
</main>
@endsection
