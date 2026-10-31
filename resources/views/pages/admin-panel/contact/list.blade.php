@extends('admin-panel')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <div class="page-header-kicker">Inbox</div>
                <h5 class="card-title mb-1">Customer Inquiries & Quotes</h5>
                <p class="text-muted mb-0">Messages and quote requests submitted from the website contact form.</p>
            </div>
        </div>

        <div class="table-responsive">
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
                            <td>{{ $message->service->title ?? 'General Inquiry' }}</td>
                            <td class="fw-semibold">{{ $message->subject }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->message, 90) }}</td>
                            <td>{{ $message->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No contact messages yet.</td>
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
