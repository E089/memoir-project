<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_to_home_on_valid_credentials()
    {
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'), 
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'password123', 
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_register_creates_user_and_redirects_to_login()
    {
        $this->withoutMiddleware();

        $response = $this->post('/register', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'securePass123',
            'password_confirmation' => 'securePass123',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
        ]);
    }
}
