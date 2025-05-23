<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_store_creates_category_with_json()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'name' => 'Work',
            'description' => 'Work-related thoughts',
        ];

        $response = $this->postJson('/categories', $payload);

        $response->assertStatus(201); 
        $this->assertDatabaseHas('categories', [
            'name' => 'Work',
            'description' => 'Work-related thoughts',
            'user_id' => $user->id,
        ]);
    }

    public function test_category_destroy_deletes_category_with_json()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/categories/{$category->id}");

        $response->assertStatus(200); 
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
