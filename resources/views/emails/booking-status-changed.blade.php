@php($siteAsset = asset('site'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);">
                    <tr>
                        <td style="background: #0d6efd; padding: 24px; color: #ffffff; text-align: center; font-size: 24px; font-weight: bold;">
                            Securex Booking Update
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px; color: #333333;">
                            <p>Hi {{ $booking->name }},</p>

                            @if($status === 'accepted' || $status === 'approved')
                                <p>Good news! Your booking request has been accepted.</p>
                                <p>We have scheduled the service for <strong>{{ optional($booking->booking_date)->format('M d, Y') ?? '-' }}</strong> at <strong>{{ $booking->time_slot ?? '-' }}</strong>.</p>
                            @elseif($status === 'rejected')
                                <p>We are sorry to inform you that your booking request could not be accepted.</p>
                                <p>Please contact support if you would like to request another service or change your booking details.</p>
                            @elseif($status === 'completed')
                                <p>Your requested service has been completed successfully.</p>
                                <p>Please complete any outstanding payment for the service below.</p>
                            @else
                                <p>Your booking status has been updated to <strong>{{ ucfirst($status) }}</strong>.</p>
                            @endif

                            <h3 style="margin-bottom: 12px;">Booking Details</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold;">Service</td>
                                    <td style="padding: 8px 0; text-align: right;">{{ $booking->service->title }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold;">Date</td>
                                    <td style="padding: 8px 0; text-align: right;">{{ optional($booking->booking_date)->format('M d, Y') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold;">Time</td>
                                    <td style="padding: 8px 0; text-align: right;">{{ $booking->time_slot ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold;">Total Cost</td>
                                    <td style="padding: 8px 0; text-align: right;">${{ number_format($booking->service_price, 2) }}</td>
                                </tr>
                            </table>

                            <p style="margin-bottom: 24px;">You can view your invoice online by clicking the button below.</p>
                            <p style="text-align: center; margin-bottom: 24px;">
                                <a href="{{ route('bookings.invoice', $booking) }}" style="background: #0d6efd; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">View Invoice</a>
                            </p>

                            <p>If you have any questions, feel free to contact our support team.</p>
                            <p>Thank you for choosing Securex.</p>
                            <p>The Securex Team</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f4f4f4; padding: 16px; text-align: center; color: #777777; font-size: 12px;">
                            Securex | Booking Notification
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
