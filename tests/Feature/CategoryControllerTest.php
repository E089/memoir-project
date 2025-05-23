<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        $this->artisan('migrate');
    }

    public function test_category_store_creates_category()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $request = Request::create('/categories', 'POST', [
            'name' => 'Work',
            'description' => 'Work-related thoughts',
        ]);

        $controller = new CategoryController();
        $response = $controller->store($request);

        $this->assertDatabaseHas('categories', [
            'name' => 'Work',
            'user_id' => $user->id,
        ]);

        $this->assertEquals(302, $response->status());
    }

    public function test_destroy_deletes_category()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Personal',
            'description' => 'Personal stuff',
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        $controller = new CategoryController();
        $response = $controller->destroy($category->id);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);

        $this->assertEquals(302, $response->status());
    }
}
