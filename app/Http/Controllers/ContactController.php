<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'phone' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $data['subject'] = $data['phone'];
        unset($data['phone']);

        ContactMessage::create($data);

        Alert::success('Success', 'Your booking request has been sent successfully.');

        return redirect(route('home') . '#booking');
    }

    public function index()
    {
        return view('pages.admin-panel.contact.list', [
            'messages' => ContactMessage::with('service')->latest()->paginate(10),
        ]);
    }
}
