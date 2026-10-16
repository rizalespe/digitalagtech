<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->published_at?->isPast(), 404);

        $registration = $request->user()->eventRegistrations()->whereBelongsTo($event)->first();

        if ($registration && $registration->status !== RegistrationStatus::Cancelled) {
            return back()->with('status', 'You are already registered for this event.');
        }

        if (! $event->acceptsRegistrations()) {
            return back()->with('error', 'Registration for this event is closed.');
        }

        $request->user()->eventRegistrations()->updateOrCreate(
            ['event_id' => $event->id],
            ['status' => RegistrationStatus::Registered],
        );

        return back()->with('status', 'You are registered! We will send the details to your email and WhatsApp.');
    }

    public function destroy(Request $request, Event $event): RedirectResponse
    {
        $request->user()->eventRegistrations()
            ->whereBelongsTo($event)
            ->update(['status' => RegistrationStatus::Cancelled]);

        return back()->with('status', 'Your registration has been cancelled.');
    }
}
