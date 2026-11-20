<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedAdmin();

        $this->call([
            SpeakerSeeder::class,
            EventSeeder::class,
            ContentSeeder::class,
            ProgramSeeder::class,
            AssessmentSeeder::class,
        ]);
    }

    /**
     * Create the initial admin account without any credential committed to the repo.
     *
     * Credentials come from ADMIN_EMAIL / ADMIN_PASSWORD in .env. If no password is
     * provided, a random one is generated and printed once to the console.
     * An existing admin account is never modified (its password is not reset).
     */
    private function seedAdmin(): void
    {
        $email = env('ADMIN_EMAIL');

        if (blank($email)) {
            $this->command?->warn('ADMIN_EMAIL is not set; skipping admin account creation.');

            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->command?->info("Admin account {$email} already exists; leaving it unchanged.");

            return;
        }

        $password = env('ADMIN_PASSWORD');
        $generated = blank($password);

        if ($generated) {
            $password = Str::password(24);
        } elseif (strlen($password) < 12) {
            throw new \RuntimeException('ADMIN_PASSWORD must be at least 12 characters long.');
        }

        (new User)->forceFill([
            'name'     => env('ADMIN_NAME', 'Admin Digital Agtech'),
            'email'    => $email,
            'password' => Hash::make($password),
            'role'     => UserRole::Admin,
        ])->save();

        if ($generated) {
            $this->command?->warn("Admin account created: {$email}");
            $this->command?->warn("Generated password (shown once, store it securely): {$password}");
        } else {
            $this->command?->info("Admin account created: {$email}. Remove ADMIN_PASSWORD from .env now.");
        }
    }
}
