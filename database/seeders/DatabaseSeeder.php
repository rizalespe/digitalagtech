<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Digital Agtech',
            'email' => 'admin@digitalagtech.id',
        ]);
        $admin->forceFill(['role' => UserRole::Admin])->save();

        $this->call([
            SpeakerSeeder::class,
            EventSeeder::class,
            ContentSeeder::class,
            ProgramSeeder::class,
            AssessmentSeeder::class,
        ]);
    }
}
