<?php

namespace Database\Seeders;

use App\Models\Speaker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $speakers = [
            ['Ahmad Syaifulloh', 'CTO Chickin', 'Precision agriculture, smart sensors & data-driven farming', 'ahmad', true],
            ['Rossena Karisma Rosul', 'Founder FDS', 'AgTech innovation, startup ecosystem & sustainable farming', 'rossena', true],
            ['Aryo Wiryawan', 'Founder JALA', 'IoT deployment, supply chain & agritech investment', 'aryo', true],
            ['Andina Paramitha', 'Founder RVare.id', 'Agricultural policy, women in agritech & rural entrepreneurship', 'andina', true],
            ['Asri Wijayanti', 'Founder MVP Room', null, 'asri', false],
            ['Pukka Simbolon', 'Founder Capcapung', null, 'pukka', false],
            ['Catur Sugiarto, Ph.D.', 'President AIBI', null, 'catur', false],
            ['Rama Mamuaya', 'Tech. Investment. Policy', null, 'rama', false],
            ['Dias Satria, Ph.D.', 'Head of Innovation Universitas Brawijaya', null, 'dias', false],
            ['Justin Ahmed', 'Beanstalk Australia', null, 'justin', false],
            ['Rachmat Anggara', 'CEO Qasir.id', null, null, false],
        ];

        foreach ($speakers as $order => [$name, $title, $expertise, $photo, $featured]) {
            Speaker::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'title' => $title,
                'expertise' => $expertise,
                'photo' => $photo ? "images/speakers/{$photo}.jpg" : null,
                'linkedin_url' => '#',
                'instagram_url' => '#',
                'is_featured' => $featured,
                'sort_order' => $order + 1,
            ]);
        }
    }
}
