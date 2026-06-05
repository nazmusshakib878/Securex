@php($siteAsset = asset('site'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Invoice</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Service Invoice</h4>
                            <small>Booking #{{ $booking->id }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info text-dark">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div>
                                <h5 class="mb-1">Billed to</h5>
                                <p class="mb-1">{{ $booking->name }}</p>
                                <p class="mb-0">{{ $booking->email }}</p>
                            </div>
                            <div class="text-end">
                                <p class="mb-1"><strong>Invoice Date:</strong> {{ $booking->created_at->format('M d, Y') }}</p>
                                <p class="mb-0"><strong>Due:</strong> ${{ number_format($booking->service_price, 2) }}</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-4">
                                <tbody>
                                    <tr>
                                        <td><strong>Service</strong></td>
                                        <td class="text-end">{{ $booking->service->title ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date</strong></td>
                                        <td class="text-end">{{ optional($booking->booking_date)->format('M d, Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Time</strong></td>
                                        <td class="text-end">{{ $booking->time_slot ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Status</strong></td>
                                        <td class="text-end">{{ $booking->status === 'completed' ? 'Pending payment' : ucfirst($booking->status) }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td><strong>Total</strong></td>
                                        <td class="text-end"><strong>${{ number_format($booking->service_price, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-4">
                            <h6>Payment Instructions</h6>
                            <p>Please complete any outstanding payment for the service listed above. If you have any questions or need assistance, contact our support team.</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.bookings') }}" class="btn btn-outline-secondary">Back to My Bookings</a>
                            <a href="mailto:info@example.com" class="btn btn-primary">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
