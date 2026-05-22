<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;

class AdminController extends Controller
{
    public function viewAdminPanel(){
        return view('pages.admin-panel.home', [
            'totalUsers' => User::count(),
            'activeServices' => Service::where('isActive', true)->count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'totalBookings' => Booking::count(),
            'recentBookings' => Booking::with(['service', 'user'])->latest()->take(5)->get(),
            'contactMessages' => ContactMessage::count(),
            'recentContactMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }

    public function users()
    {
        return view('pages.admin-panel.users.list', [
            'users' => User::latest()->paginate(10),
        ]);
    }
    
}
