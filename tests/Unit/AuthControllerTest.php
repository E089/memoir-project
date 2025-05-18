<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        $this->artisan('migrate');
    }

    public function test_login_redirects_to_home_on_valid_credentials()
    {
        $user = User::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $request = Request::create('/login', 'POST', [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $controller = new AuthController();
        $response = $controller->login($request);

        $this->assertEquals(302, $response->status());
        $this->assertEquals('/home', parse_url($response->getTargetUrl(), PHP_URL_PATH));
    }

    public function test_register_creates_user_and_redirects_to_login()
    {
        $request = Request::create('/register', 'POST', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'securePass123',
            'password_confirmation' => 'securePass123',
        ]);

        $controller = new AuthController();
        $response = $controller->register($request);

        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('login'), $response->getTargetUrl());
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
        ]);
    }

}
