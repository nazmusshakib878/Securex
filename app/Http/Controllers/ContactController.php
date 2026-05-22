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
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($data);

        Alert::success('Success', 'Your message has been sent successfully.');

        return redirect(route('home') . '#contact');
    }

    public function index()
    {
        return view('pages.admin-panel.contact.list', [
            'messages' => ContactMessage::with('service')->latest()->paginate(10),
        ]);
    }
}
