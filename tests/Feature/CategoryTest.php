<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created_with_valid_fields()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
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
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $category->user);
        $this->assertEquals($user->id, $category->user->id);
    }
}
