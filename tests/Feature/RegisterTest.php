<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterTest extends TestCase
{
    public function test_registration_validation()
    {
        // Start a session explicitly
        $this->startSession();

        // Simulate a valid CSRF token in the request
        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->post('/register', [
            'username' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // Ensure that validation errors are present
        $response->assertSessionHasErrors(['username', 'email', 'password']);
    }

    public function test_registration_creates_user()
    {
        // Test successful registration
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Using DB transaction to avoid using RefreshDatabase
        DB::beginTransaction();

        $response = $this->post('/register', $userData);

        // Assert the user is created
        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect(route('login'));

        // Rollback transaction to not affect the database
        DB::rollBack();
    }

    public function test_registration_with_existing_username()
    {
        // Test unique username validation
        User::create([
            'username' => 'existinguser',
            'email' => 'existing@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/register', [
            'username' => 'existinguser',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_registration_with_existing_email()
    {
        // Test unique email validation
        User::create([
            'username' => 'newuser',
            'email' => 'existing@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/register', [
            'username' => 'newuser2',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
