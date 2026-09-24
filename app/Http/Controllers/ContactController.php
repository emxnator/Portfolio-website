<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact-messages.index', [
            'messages' => ContactMessage::latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(Auth::check(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return redirect(route('home').'#contact')->with('status', 'Bedankt voor je bericht! Ik neem zo snel mogelijk contact met je op.');
    }
}
