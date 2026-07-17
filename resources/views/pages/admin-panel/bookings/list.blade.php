@extends('admin-panel')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <div class="page-header-kicker">Bookings</div>
                <h5 class="card-title mb-1">Booking Requests</h5>
                <p class="text-muted mb-0">Review and update booking statuses from users.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
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
                            <td>{{ $booking->user->name ?? $booking->name }}</td>
                            <td>{{ $booking->service->title ?? 'N/A' }}</td>
                            <td>${{ number_format($booking->service_price, 2) }}</td>
                            <td>{{ optional($booking->booking_date)->format('M d, Y') ?? '-' }}</td>
                            <td>{{ $booking->time_slot ?? '-' }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>
                                <span class="badge bg-{{ $statusBadge }}">
                                    {{ ucfirst($displayStatus) }}
                                </span>
                            </td>
                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="booking-actions">
                                    @if($displayStatus === 'pending')
                                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="action-form">
                                            @csrf
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>
                                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="action-form">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    @elseif(in_array($displayStatus, ['accepted'], true))
                                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="action-form">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-warning text-dark">Complete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">No booking requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
