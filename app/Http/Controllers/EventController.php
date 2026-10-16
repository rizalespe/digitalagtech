<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $showPast = $request->query('when') === 'past';

        $events = Event::published()
            ->when($showPast, fn ($query) => $query->past(), fn ($query) => $query->upcoming())
            ->paginate(8)
            ->withQueryString();

        return view('events.index', [
            'events' => $events,
            'showPast' => $showPast,
        ]);
    }

    public function show(Request $request, Event $event): View
    {
        abort_unless($event->published_at?->isPast(), 404);

        $event->load(['sessions', 'speakers' => fn ($query) => $query->ordered()]);

        return view('events.show', [
            'event' => $event,
            'registration' => $request->user()?->eventRegistrations()->whereBelongsTo($event)->first(),
        ]);
    }
}
