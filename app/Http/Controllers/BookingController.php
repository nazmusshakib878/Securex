<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    public function createBooking(Request $req){
        if (! Auth::check()) {
            Alert::info("Login Required", "Please login before submitting a booking.");
            return redirect()->route('login');
        }

        $validated = $req->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'service' => ['required', 'exists:services,id'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $data["name"] = $validated['name'];
        $data["email"] = $validated['email'];
        $data["message"] = $validated['message'] ?? null;
        $data["service_id"] = $validated['service'];
        $data["user_id"] = Auth::user()->id;

        Booking::create($data);
        Alert::success("Success", "Booking submitted successfully");
        return redirect()->back();
    }
}
