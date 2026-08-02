<?php

namespace App\Http\Controllers;

use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
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
        try {
            $bookings = Auth::user()->bookings()->with('service')->latest()->paginate(10);

            return view('pages.bookings', [
                'bookings' => $bookings,
            ]);
        } catch (QueryException $e) {
            logger()->error('Failed to load bookings for user: '.$e->getMessage());
            Alert::error('Error', 'Unable to load your bookings at the moment. Please try again later.');
            return redirect()->route('home');
        }
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
            'status' => ['required', 'in:accepted,rejected,completed'],
        ]);

        $currentStatus = $booking->status === 'approved' ? 'accepted' : $booking->status;
        $newStatus = $validated['status'];

        if (in_array($currentStatus, ['rejected', 'completed'], true)) {
            Alert::warning('Invalid action', 'This booking cannot be updated further.');
            return redirect()->back();
        }

        $allowedTransitions = [
            'pending' => ['accepted', 'rejected'],
            'accepted' => ['completed'],
        ];

        if (! isset($allowedTransitions[$currentStatus]) || ! in_array($newStatus, $allowedTransitions[$currentStatus], true)) {
            Alert::warning('Invalid transition', 'The requested status change is not permitted.');
            return redirect()->back();
        }

        $oldStatus = $booking->status;

        $updated = app('db')->transaction(function () use ($booking, $newStatus): bool {
            $lockedBooking = Booking::query()->lockForUpdate()->findOrFail($booking->id);

            if ($newStatus === 'accepted') {
                $conflictingBooking = Booking::query()
                    ->whereKeyNot($lockedBooking->id)
                    ->where('booking_date', $lockedBooking->booking_date)
                    ->where('time_slot', $lockedBooking->time_slot)
                    ->whereIn('status', ['accepted', 'approved'])
                    ->lockForUpdate()
                    ->first();

                if ($conflictingBooking) {
                    return false;
                }
            }

            $lockedBooking->update(['status' => $newStatus]);

            return true;
        });

        if (! $updated) {
            Alert::error('Slot unavailable', 'Another booking already occupies this date and time slot.');

            return redirect()->back();
        }

        if ($oldStatus !== $newStatus) {
            Mail::to($booking->email)->send(new BookingStatusChanged($booking, $newStatus));
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

        if (! in_array($booking->status, ['pending', 'accepted', 'approved'], true)) {
            Alert::info('Notice', 'This booking can no longer be canceled.');
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

        $bookedSlots = Booking::where('booking_date', $bookingDate)
            ->where('status', 'accepted')
            ->pluck('time_slot')
            ->toArray();

        $availableSlots = array_values(array_diff(self::TIME_SLOTS, $bookedSlots));

        if (in_array($requestedSlot, $bookedSlots, true)) {
            $availableSlotList = empty($availableSlots) ? 'None' : implode(', ', $availableSlots);

            return Redirect::back()
                ->withErrors([
                    'time_slot' => "This slot is already booked. Please choose another time. Available slots for this date: {$availableSlotList}",
                ])
                ->withInput();
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
            'status' => 'pending',
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
