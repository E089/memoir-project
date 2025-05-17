<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_is_accessible()
    {
        $response = $this->get('/welcome-page');
        $response->assertStatus(200);
        $response->assertViewIs('welcome-page');
    }

    public function test_register_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

   public function test_register_post_creates_user()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }



    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login_post_redirects_on_success()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password = bcrypt('secret123');
        $user->save();

        $response = $this->withoutMiddleware()->post('/login', [
            'username' => 'testuser',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('home'));
    }

    public function test_logout_logs_user_out()
    {
        $user = User::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->be($user); // Simulate login

        $response = $this->get('/logout'); // Match your route (GET)

        $response->assertRedirect(route('welcome-page'));

        $this->assertGuest(); // Confirms user is logged out
    }

   public function test_home_allows_guest_access()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);
    }


    public function test_home_accessible_by_authenticated_user()
    {
        $user = User::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->be($user); // Simulate login

        $response = $this->get('/home');
        $response->assertStatus(200);
        $response->assertViewIs('home'); // Optional: confirm the correct view
    }

}
