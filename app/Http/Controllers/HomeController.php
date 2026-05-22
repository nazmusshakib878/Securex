<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function viewHomePage()
    {
        $services = Service::where(["isActive" => 1])->get();
        return view('pages.home', ["services"=>$services]);
    }
}
