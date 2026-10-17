<?php

namespace Database\Seeders;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $description = <<<'HTML'
            <p>This event is a webinar and launchpad program for aspiring AgTech entrepreneurs to learn how to build <strong>sustainable and scalable startups</strong>.</p>
            <p>Learn from AgTech founders, expand your network, and connect with ecosystem builders. Selected participants will have the opportunity to join an <strong>Intensive Workshop</strong>.</p>
            HTML;

        $webinar = Event::firstOrCreate(
            ['slug' => 'from-idea-to-scale-webinar'],
            [
                'title'          => 'From Idea to Scale: Startup Pertanian',
                'type'           => EventType::Webinar,
                'summary'        => 'A webinar and launchpad program for aspiring AgTech entrepreneurs to learn how to build sustainable and scalable startups.',
                'description'    => $description,
                'starts_at'      => '2026-09-29 09:00:00',
                'ends_at'        => '2026-09-29 11:00:00',
                'location'       => 'Zoom Meeting',
                'is_online'      => true,
                'thumbnail'      => 'images/events/event-1.jpg',
                'flyer'          => 'images/events/event-flyer.jpg',
                'workshop_cities' => ['Malang', 'Yogyakarta', 'Lampung'],
                'is_featured'    => true,
                'published_at'   => now(),
            ]
        );

        if ($webinar->wasRecentlyCreated) {
            $webinar->sessions()->createMany([
                ['starts_at' => '09:00', 'ends_at' => '09:20', 'title' => 'Opening & Setting the Scene', 'sort_order' => 1],
                ['starts_at' => '09:20', 'ends_at' => '09:40', 'title' => 'Keynote: Problem–Solution Fit', 'sort_order' => 2],
                ['starts_at' => '09:40', 'ends_at' => '09:50', 'title' => 'Keynote: Market Fit & Adoption', 'sort_order' => 3],
                ['starts_at' => '09:50', 'ends_at' => '10:00', 'title' => 'Incubation, Investment & Venture Perspectives', 'sort_order' => 4],
                ['starts_at' => '10:00', 'ends_at' => '10:15', 'title' => 'Sustainability, Growth & Panel Discussion', 'sort_order' => 5],
                ['starts_at' => '10:15', 'ends_at' => '11:00', 'title' => 'Key Takeaways, Q&A & Closing', 'sort_order' => 6],
            ]);
        }

        $workshop = Event::firstOrCreate(
            ['slug' => 'from-idea-to-scale-workshop-malang'],
            [
                'title'        => 'From Idea to Scale: Startup Pertanian',
                'type'         => EventType::Workshop,
                'summary'      => 'An intensive, in-person workshop for selected webinar participants.',
                'description'  => $description,
                'starts_at'    => '2026-10-31 08:00:00',
                'ends_at'      => '2026-10-31 16:00:00',
                'location'     => 'Niat Baik Gn. Kawi, Malang',
                'city'         => 'Malang',
                'thumbnail'    => 'images/events/event-2.jpg',
                'quota'        => 50,
                'published_at' => now(),
            ]
        );

        $featured = Speaker::where('is_featured', true)->pluck('id');

        if ($webinar->wasRecentlyCreated) {
            $webinar->speakers()->attach($featured);
        }
        if ($workshop->wasRecentlyCreated) {
            $workshop->speakers()->attach($featured->take(2));
        }
    }
}
