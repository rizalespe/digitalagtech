<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@digitalagtech.id'],
            [
                'name'     => 'Admin Digital Agtech',
                'password' => Hash::make('password'),
                'role'     => UserRole::Admin,
            ]
        );

        $this->call([
            SpeakerSeeder::class,
            EventSeeder::class,
            ContentSeeder::class,
            ProgramSeeder::class,
            AssessmentSeeder::class,
        ]);
    }
}
