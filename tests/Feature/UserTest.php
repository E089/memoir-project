<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_valid_fields()
    {
        $user = User::factory()->create([
            'username' => 'janedoe',
            'email' => 'jane@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'janedoe',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_user_password_is_hidden_in_array()
    {
        $user = User::factory()->create([
            'username' => 'hiddenpass',
            'email' => 'hidden@example.com',
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_user_casts_timestamps_as_datetime()
    {
        $user = User::factory()->create([
            'username' => 'castcheck',
            'email' => 'cast@example.com',
        ]);

        $this->assertInstanceOf(Carbon::class, $user->created_at);
        $this->assertInstanceOf(Carbon::class, $user->updated_at);
    }
}
