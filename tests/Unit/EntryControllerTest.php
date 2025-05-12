<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\EntryController;

class EntryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        $this->artisan('migrate');
    }

    public function test_save_entry_creates_entry_and_redirects()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Optional: create a category
        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'For testing',
            'user_id' => $user->id,
        ]);

        // Create fake request
        $request = Request::create('/save-entry', 'POST', [
            'title' => 'My First Entry',
            'body' => 'This is a test entry body.',
            'category_id' => $category->id,
        ]);

        // Call controller
        $controller = new EntryController();
        $response = $controller->saveEntry($request);

        // Assert redirect
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('view-all-thoughts'), $response->getTargetUrl());

        // Check DB
        $this->assertDatabaseHas('entries', [
            'title' => 'My First Entry',
            'body' => 'This is a test entry body.',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }

//     public function test_save_entry_with_tags_creates_tags_and_attaches_them()
// {
//     $user = User::factory()->create();
//     $this->actingAs($user);

//     $category = Category::create([
//         'name' => 'Tagged Category',
//         'description' => 'Category for entry with tags',
//         'user_id' => $user->id,
//     ]);

//     $request = Request::create('/save-entry', 'POST', [
//         'title' => 'Entry with tags',
//         'body' => 'This is a test entry with tags.',
//         'category_id' => $category->id,
//         'tags' => json_encode(['tag1', 'tag2', 'tag3']),
//     ]);

//     $controller = new \App\Http\Controllers\EntryController();
//     $response = $controller->saveEntry($request);

//     $this->assertEquals(302, $response->status());
//     $this->assertEquals(route('view-all-thoughts'), $response->getTargetUrl());

//     $entry = \App\Models\Entry::with('tags')->where('title', 'Entry with tags')->first();

// $this->assertNotNull($entry, 'Entry was not created.');
// $this->assertCount(3, $entry->tags ?? [], 'Tags were not attached correctly.');

// }


}
