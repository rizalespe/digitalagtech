<?php

namespace Database\Seeders;

use App\Enums\ToolkitStage;
use App\Models\IncubationProgram;
use App\Models\Toolkit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Jagoan Tani Banyuwangi',
                'description' => 'Jagoan Tani Banyuwangi is a business incubation program that empowers young agricultural entrepreneurs to develop innovative and sustainable agribusiness ideas. Through mentorship, hands-on learning, and business development, participants are guided to transform agricultural challenges into viable business opportunities and scalable solutions.',
            ],
            [
                'name' => 'Kita Tani Muda Semarang',
                'description' => 'Kita Tani Muda Semarang is a business incubation program designed to empower young entrepreneurs in developing innovative and sustainable agricultural businesses. Through mentorship, practical learning, and business development, participants are guided to turn their ideas into viable solutions and create meaningful impact in the agricultural sector.',
            ],
        ];

        foreach ($programs as $i => $data) {
            $slug = Str::slug($data['name']);

            $program = IncubationProgram::firstOrCreate(
                ['slug' => $slug],
                [
                    ...$data,
                    'cover_image' => "images/programs/{$slug}.jpg",
                    'sort_order'  => $i + 1,
                ]
            );

            if ($program->wasRecentlyCreated) {
            $program->photos()->createMany([
                ['image' => 'images/gallery/bi-gallery-1.jpg', 'caption' => "Peserta {$data['name']} berfoto bersama", 'sort_order' => 1],
                ['image' => 'images/gallery/bi-gallery-2.jpg', 'caption' => "Sesi mentoring {$data['name']}", 'sort_order' => 2],
                ['image' => 'images/gallery/bi-gallery-3.jpg', 'caption' => "Peserta {$data['name']} menempel sticky notes", 'sort_order' => 3],
            ]);
            } // end wasRecentlyCreated
        }

        $toolkits = [
            ['Ideation & Problem Discovery', ToolkitStage::Discover, 'ideation', 'Uncover real agricultural pain points and generate validated ideas through structured discovery frameworks and field research techniques.', 6, 8, '2–3 Hours'],
            ['Validation & Problem–Solution Fit', ToolkitStage::Discover, 'validation', 'Test your assumptions fast with lightweight experiments. Learn to validate your solution concept before committing to a build.', 5, 7, '3–4 Hours'],
            ['Product–Market Fit', ToolkitStage::Build, 'pmf', 'Align your AgTech product with real market demand. Use metrics, user feedback loops, and iteration cycles to find the sweet spot.', 7, 9, '4–5 Hours'],
            ['Scaling & Growth', ToolkitStage::Scale, 'scaling', 'Design your go-to-market strategy and growth engine. Build channels, partnerships, and distribution networks across the agri-sector.', 6, 8, '3–4 Hours'],
            ['Maturity & Expansion', ToolkitStage::Scale, 'maturity', 'Sustain momentum and expand into new markets. Explore strategic pivots, regional scaling, and long-term resilience for AgTech ventures.', 5, 6, '2–3 Hours'],
        ];

        foreach ($toolkits as $i => [$title, $stage, $image, $description, $tools, $activities, $duration]) {
            Toolkit::firstOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title'            => $title,
                    'stage'            => $stage,
                    'description'      => $description,
                    'thumbnail'        => "images/toolkits/{$image}.jpg",
                    'tools_count'      => $tools,
                    'activities_count' => $activities,
                    'duration_label'   => $duration,
                    'sort_order'       => $i + 1,
                ]
            );
        }
    }
}
