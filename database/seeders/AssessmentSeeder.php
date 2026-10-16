<?php

namespace Database\Seeders;

use App\Models\AssessmentDimension;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Contoh pertanyaan Startup Assessment. Ganti dengan instrumen final dari tim program.
 */
class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $dimensions = [
            'Market Fit' => 'Seberapa jelas pelanggan yang membayar untuk solusi Anda?',
            'Scale' => 'Apakah model bisnis Anda sudah dapat direplikasi di wilayah lain?',
            'Traction' => 'Berapa banyak pengguna aktif atau petani yang sudah memakai solusi Anda?',
            'Funding' => 'Sumber pendanaan apa yang sudah Anda peroleh?',
            'Product' => 'Bagaimana status produk Anda saat ini?',
            'Team' => 'Bagaimana komposisi tim inti Anda?',
        ];

        $options = [
            ['Belum ada / masih ide', 0],
            ['Tahap awal, sedang divalidasi', 35],
            ['Sudah berjalan dan terbukti di skala kecil', 70],
            ['Sudah kuat dan terukur', 100],
        ];

        foreach (array_keys($dimensions) as $order => $name) {
            $dimension = AssessmentDimension::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'sort_order' => $order + 1,
            ]);

            $question = $dimension->questions()->create([
                'question' => $dimensions[$name],
                'sort_order' => 1,
            ]);

            foreach ($options as $i => [$label, $score]) {
                $question->options()->create([
                    'label' => $label,
                    'score' => $score,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
