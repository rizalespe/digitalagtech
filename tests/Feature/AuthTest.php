<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siti Petani',
            'email' => 'siti@example.com',
            'whatsapp' => '0812-3456-7890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => '1',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'siti@example.com',
            'whatsapp' => '+6281234567890',
            'role' => 'participant',
        ]);
    }

    public function test_registration_requires_accepting_terms(): void
    {
        $this->post('/register', [
            'name' => 'Siti Petani',
            'email' => 'siti@example.com',
            'whatsapp' => '+62 812 3456 7890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('terms');

        $this->assertGuest();
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
