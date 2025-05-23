<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Entry;
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
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'For testing',
            'user_id' => $user->id,
        ]);

        $request = Request::create('/save-entry', 'POST', [
            'title' => 'My First Entry',
            'body' => 'This is a test entry body.',
            'category_id' => $category->id,
        ]);

        $controller = new EntryController();
        $response = $controller->saveEntry($request);

        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('view-all-thoughts'), $response->getTargetUrl());

        $this->assertDatabaseHas('entries', [
            'title' => 'My First Entry',
            'body' => 'This is a test entry body.',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_view_all_entries_returns_filtered_entries()
    {
        $user = User::create([
            'username' => 'viewer',
            'email' => 'viewer@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->actingAs($user);

        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'Test Description',
            'user_id' => $user->id,
        ]);

        $tag = Tag::create([
            'name' => 'Test Tag',
            'user_id' => $user->id,
        ]);

        $entryWithTag = Entry::create([
            'title' => 'Entry With Tag',
            'body' => 'Has the tag.',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $entryWithTag->tags()->attach($tag->id);

        $entryWithoutTag = Entry::create([
            'title' => 'Other Entry',
            'body' => 'No tag here.',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $request = Request::create('/view-all-thoughts', 'GET', [
            'tag' => $tag->id,
        ]);

        $controller = new EntryController();
        $response = $controller->viewAllEntries($request);

        $viewEntries = $response->getData()['entries'];

        $this->assertCount(1, $viewEntries);
        $this->assertEquals('Entry With Tag', $viewEntries->first()->title);
    }

    public function test_show_entry_displays_view_with_tags()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $entry = Entry::create([
            'title' => 'Entry with Tags',
            'body' => '<p>Body content here</p>',
            'user_id' => $user->id,
        ]);

        $tags = ['tag1', 'tag2', 'tag3', 'tag4'];
        foreach ($tags as $tagName) {
            $tag = Tag::create(['name' => $tagName, 'user_id' => $user->id]);
            $entry->tags()->attach($tag);
        }

        $controller = new EntryController();
        $response = $controller->showEntry($entry->id);

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('view-single-thought', $response->name());

        $data = $response->getData();
        $this->assertEquals($entry->id, $data['entry']->id);
        $this->assertCount(4, $data['entry']->tags);
    }

    public function test_edit_entry_loads_correct_view_and_data()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $category = Category::create([
            'name' => 'Personal',
            'description' => 'Private stuff',
            'user_id' => $user->id,
        ]);

        $entry = Entry::create([
            'title' => 'Editable Entry',
            'body' => 'Some content here',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $tag = Tag::create([
            'name' => 'Important',
            'user_id' => $user->id,
        ]);
        $entry->tags()->attach($tag->id);

        $controller = new EntryController();
        $response = $controller->editEntry($entry->id);

        $this->assertEquals('edit-entry', $response->getName());

        $viewData = $response->getData();
        $this->assertEquals($entry->id, $viewData['entry']->id);
        $this->assertCount(1, $viewData['categories']);
        $this->assertEquals('Personal', $viewData['categories'][0]->name);
    }

    public function test_update_entry_updates_entry_and_tags_correctly()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $initialCategory = Category::create([
            'name' => 'Initial Category',
            'description' => 'Initial',
            'user_id' => $user->id,
        ]);

        $entry = Entry::create([
            'title' => 'Original Title',
            'body' => '<p>Original Body</p>',
            'user_id' => $user->id,
            'category_id' => $initialCategory->id,
        ]);

        $existingTag = Tag::create([
            'name' => 'existing',
            'user_id' => $user->id,
        ]);

        $entry->tags()->attach($existingTag->id);

        $request = Request::create(route('entries.update', $entry->id), 'PUT', [
            'title' => 'Updated Title',
            'body' => '<p>Updated Body</p>',
            'category_id' => $initialCategory->id,
            'tags' => json_encode(['newtag', 'existing']), 
        ]);

        $controller = new EntryController();
        $response = $controller->updateEntry($request, $entry->id);

        $entry->refresh();

        $this->assertEquals('Updated Title', $entry->title);
        $this->assertEquals('<p>Updated Body</p>', $entry->body);
        $this->assertEquals($initialCategory->id, $entry->category_id);

        $tagNames = $entry->tags()->pluck('name')->toArray();
        $this->assertCount(2, $tagNames);
        $this->assertContains('existing', $tagNames);
        $this->assertContains('newtag', $tagNames);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(route('view-all-thoughts'), $response->getTargetUrl());
    }

    public function test_delete_entry_removes_entry_and_redirects()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $entry = Entry::create([
            'title' => 'Delete Me',
            'body' => 'Temporary content',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('entries', ['id' => $entry->id]);

        $controller = new EntryController();
        $response = $controller->deleteEntry($entry->id);

        $this->assertDatabaseMissing('entries', ['id' => $entry->id]);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(route('view-all-thoughts'), $response->getTargetUrl());
    }


}
