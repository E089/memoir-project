<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created_with_valid_fields()
    {
        $user = User::create([
            'username' => 'catuser',
            'email' => 'cat@example.com',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create([
            'name' => 'Personal',
            'description' => 'Personal notes and ideas',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Personal',
            'description' => 'Personal notes and ideas',
            'user_id' => $user->id,
        ]);
    }

    public function test_category_belongs_to_user()
    {
        $user = User::create([
            'username' => 'reluser',
            'email' => 'rel@example.com',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create([
            'name' => 'Work',
            'description' => 'Work-related tasks',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $category->user);
        $this->assertEquals($user->id, $category->user->id);
    }
}
