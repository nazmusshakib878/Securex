@extends('admin-panel')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <div class="page-header-kicker">Inbox</div>
                    <h5 class="card-title mb-1">Booking Requests</h5>
                    <p class="text-muted mb-0">Requests submitted from the website booking form.</p>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Phone Number</th>
                        <th>Message</th>
                        <th>Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td class="fw-semibold">{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->service->title ?? 'N/A' }}</td>
                            <td class="fw-semibold">{{ $message->subject }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->message, 90) }}</td>
                            <td>{{ $message->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No booking requests yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
