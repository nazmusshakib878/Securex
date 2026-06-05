<?php

namespace App\Http\Controllers;

use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    private const TIME_SLOTS = [
        '09:00 AM',
        '11:00 AM',
        '01:00 PM',
        '03:00 PM',
        '05:00 PM',
    ];

    public function index()
    {
        $bookings = Auth::user()->bookings()->with('service')->latest()->paginate(10);

        return view('pages.bookings', [
            'bookings' => $bookings,
        ]);
    }

    public function adminIndex()
    {
        $bookings = Booking::with(['service', 'user'])->latest()->paginate(20);

        return view('pages.admin-panel.bookings.list', [
            'bookings' => $bookings,
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,completed'],
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $validated['status']]);

        if ($oldStatus !== $validated['status'] && in_array($validated['status'], ['approved', 'rejected', 'completed'], true)) {
            Mail::to($booking->email)->send(new BookingStatusChanged($booking, $validated['status']));
            Alert::success('Success', 'Booking status updated and notification email sent.');
        } else {
            Alert::success('Success', 'Booking status updated successfully.');
        }

        return redirect()->back();
    }

    public function invoice(Booking $booking)
    {
        if (! Auth::check() || (Auth::id() !== $booking->user_id && ! Auth::user()->isAdmin)) {
            Alert::error('Error', 'You are not authorized to view this invoice.');
            return redirect()->route('user.bookings');
        }

        $booking->load('service');

        return view('pages.booking-invoice', [
            'booking' => $booking,
        ]);
    }

    public function cancel(Booking $booking)
    {
        if (! Auth::check() || Auth::id() !== $booking->user_id) {
            Alert::error('Error', 'You are not authorized to cancel this booking.');
            return redirect()->back();
        }

        if ($booking->status === 'canceled') {
            Alert::info('Notice', 'This booking is already canceled.');
            return redirect()->back();
        }

        $booking->update(['status' => 'canceled']);

        Alert::success('Success', 'Booking canceled successfully.');
        return redirect()->back();
    }

    public function createBooking(Request $req)
    {
        if (! Auth::check()) {
            Alert::info('Login Required', 'Please login before submitting a booking.');
            return redirect()->route('login');
        }

        $validated = $req->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'service' => ['required', 'exists:services,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', Rule::in(self::TIME_SLOTS)],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $service = Service::findOrFail($validated['service']);
        $bookingDate = Carbon::parse($validated['booking_date'])->toDateString();
        $requestedSlot = $validated['time_slot'];

        $bookedSlots = Booking::where('service_id', $service->id)
            ->where('booking_date', $bookingDate)
            ->pluck('time_slot')
            ->toArray();

        $availableSlots = array_values(array_diff(self::TIME_SLOTS, $bookedSlots));

        if (empty($availableSlots)) {
            $next = $this->findNextAvailableSlot($service->id, $bookingDate);
            $message = "No slots are available on {$bookingDate}.";

            if ($next) {
                $message .= " Next available appointment is {$next['booking_date']} at {$next['time_slot']}.";
            } else {
                $message .= ' Please try a different date or contact support for assistance.';
            }

            Alert::warning('No slots available', $message);
            return Redirect::back()->withInput();
        }

        if (in_array($requestedSlot, $bookedSlots, true)) {
            $nextSlot = $availableSlots[0];
            $next = $this->findNextAvailableSlot($service->id, $bookingDate);
            $message = "The chosen slot {$requestedSlot} is already booked on {$bookingDate}. Next open slot on that day is {$nextSlot}.";

            if ($next && $next['booking_date'] !== $bookingDate) {
                $message .= " If you need another day, the next available appointment is {$next['booking_date']} at {$next['time_slot']}.";
            }

            Alert::warning('Slot unavailable', $message);
            return Redirect::back()->withInput();
        }

        Booking::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'service_id' => $service->id,
            'user_id' => Auth::user()->id,
            'message' => $validated['message'] ?? null,
            'booking_date' => $bookingDate,
            'time_slot' => $requestedSlot,
            'service_price' => $service->price,
        ]);

        Alert::success('Success', 'Booking submitted successfully');
        return redirect()->back();
    }

    private function findNextAvailableSlot(int $serviceId, string $startDate): ?array
    {
        $start = Carbon::parse($startDate);

        for ($day = 1; $day <= 30; $day++) {
            $date = $start->copy()->addDays($day)->toDateString();
            $bookedSlots = Booking::where('service_id', $serviceId)
                ->where('booking_date', $date)
                ->pluck('time_slot')
                ->toArray();

            $availableSlots = array_diff(self::TIME_SLOTS, $bookedSlots);

            if (! empty($availableSlots)) {
                return [
                    'booking_date' => $date,
                    'time_slot' => array_values($availableSlots)[0],
                ];
            }
        }

        return null;
    }
}
