<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('newsletter', [
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => strtolower($validated['email'])],
            ['unsubscribed_at' => null],
        );

        return back()->with('status', 'Thanks for subscribing! We will keep you posted.');
    }
}
