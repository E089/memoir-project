<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_valid_fields()
    {
        $user = User::create([
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'janedoe',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_user_password_is_hidden_in_array()
    {
        $user = User::create([
            'username' => 'hiddenpass',
            'email' => 'hidden@example.com',
            'password' => bcrypt('hidden123'),
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_user_casts_timestamps_as_datetime()
    {
        $user = User::create([
            'username' => 'castcheck',
            'email' => 'cast@example.com',
            'password' => bcrypt('pass123'),
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->created_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->updated_at);
    }
    
}
