@php($siteAsset = asset('site'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Completed</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);">
                    <tr>
                        <td style="background: #0d6efd; padding: 24px; color: #ffffff; text-align: center; font-size: 24px; font-weight: bold;">
                            Securex Service Completed
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px; color: #333333;">
                            <p>Hi {{ $booking->name }},</p>
                            <p>Your requested service has been completed successfully.</p>
                            <p>Please review your invoice below and complete any outstanding payment.</p>
                            <h3 style="margin-bottom: 12px;">Invoice Summary</h3>
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
                            <p style="margin-bottom: 24px;">To view your invoice online, click the button below:</p>
                            <p style="text-align: center; margin-bottom: 24px;">
                                <a href="{{ route('bookings.invoice', $booking) }}" style="background: #0d6efd; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">View Invoice</a>
                            </p>
                            <p>If there is any outstanding payment, please complete it at your earliest convenience.</p>
                            <p>Thank you for choosing Securex.</p>
                            <p>The Securex Team</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f4f4f4; padding: 16px; text-align: center; color: #777777; font-size: 12px;">
                            Securex | Service Completion Notification
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
