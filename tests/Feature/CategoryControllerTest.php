<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_store_creates_category_with_form_request()
    {
        $this->withoutMiddleware(); 

        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'name' => 'Work',
            'description' => 'Work-related thoughts',
        ];

        $response = $this->post('/categories', $payload);

        $response->assertRedirect(route('view-all-thoughts'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Work',
            'description' => 'Work-related thoughts',
            'user_id' => $user->id,
        ]);
    }

   public function test_category_destroy_deletes_category()
    {
        $this->withoutMiddleware(); 

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->delete("/categories/{$category->id}");

        $response->assertRedirect(route('view-all-thoughts'));

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

}
