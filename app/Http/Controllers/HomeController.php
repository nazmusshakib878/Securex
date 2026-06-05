<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function viewHomePage()
    {
        $services = Service::where(['isActive' => 1])->get();
        $timeSlots = [
            '09:00 AM',
            '11:00 AM',
            '01:00 PM',
            '03:00 PM',
            '05:00 PM',
        ];

        return view('pages.home', [
            'services' => $services,
            'timeSlots' => $timeSlots,
        ]);
    }
}
