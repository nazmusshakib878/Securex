<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $status;

    public function __construct(Booking $booking, string $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    public function build()
    {
        $subject = match ($this->status) {
            'accepted', 'approved' => 'Your service booking has been accepted',
            'rejected' => 'Your service booking was rejected',
            'completed' => 'Your service booking has been completed',
            default => 'Your booking status has been updated',
        };

        return $this->subject($subject)
            ->view('emails.booking-status-changed')
            ->with([
                'booking' => $this->booking,
                'status' => $this->status,
            ]);
    }
}
