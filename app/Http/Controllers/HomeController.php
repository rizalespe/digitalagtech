<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Speaker;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredEvent = Event::published()
            ->where('is_featured', true)
            ->with('sessions')
            ->latest('starts_at')
            ->first();

        // Most recent four events, shown in date order.
        $events = Event::published()->latest('starts_at')->take(4)->get()->sortBy('starts_at')->values();

        return view('home', [
            'featuredEvent' => $featuredEvent,
            'events' => $events,
            'speakers' => Speaker::featured()->ordered()->take(4)->get(),
            'photos' => GalleryPhoto::latest()->take(3)->get(),
            'partners' => Partner::active()->get(),
            'posts' => Post::published()->take(3)->get(),
        ]);
    }
}
