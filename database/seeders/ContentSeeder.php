<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Partner;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            ['How Technology Is Transforming Agriculture for a Smarter Future', 'news-1'],
            ['Computer Vision Is Catching Disease in Greenhouse Crops', 'news-2'],
            ['Vertical Farming Reaches Cost Parity With Field Crops', 'news-3'],
        ];

        // Placeholder copy; replace with real articles.
        $excerpt = 'Insights from the Digital Agtech Indonesia team on how technology is reshaping the way we grow, manage, and sell food.';
        $body = <<<'HTML'
            <p>Agriculture is an opportunity, and technology makes it possible. Across Indonesia, a new generation of founders is building tools that help farmers grow more with less.</p>
            <p>This article is placeholder content. Replace it with the full story from the editorial team.</p>
            HTML;

        foreach ($posts as $i => [$title, $image]) {
            Post::firstOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title'        => $title,
                    'excerpt'      => $excerpt,
                    'body'         => $body,
                    'thumbnail'    => "images/news/{$image}.jpg",
                    'published_at' => now()->subDays($i + 1),
                ]
            );
        }

        $webinarId = Event::where('slug', 'from-idea-to-scale-webinar')->value('id');

        $photos = [
            ['gallery-1', 'Foto bersama peserta'],
            ['gallery-2', 'Diskusi mentor dengan peserta'],
            ['gallery-3', 'Peserta menempel sticky notes'],
        ];

        foreach ($photos as $i => [$image, $caption]) {
            GalleryPhoto::firstOrCreate(
                ['image' => "images/gallery/{$image}.jpg"],
                [
                    'event_id'   => $webinarId,
                    'caption'    => $caption,
                    'sort_order' => $i + 1,
                ]
            );
        }

        $partners = [
            ['Beanstalk', 'beanstalk'],
            ['JALA', 'jala'],
            ['RWARE', 'rware'],
            ['Capcapung', 'capcapung'],
            ['Full Drone Solutions', 'fds'],
            ['Chickin', 'chickin'],
        ];

        foreach ($partners as $i => [$name, $logo]) {
            Partner::firstOrCreate(
                ['name' => $name],
                [
                    'logo'       => "images/partners/{$logo}.png",
                    'sort_order' => $i + 1,
                ]
            );
        }
    }
}
