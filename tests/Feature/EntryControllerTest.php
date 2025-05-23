<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_entry_creates_entry_and_redirects()
    {
        $this->withoutMiddleware(); 
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->post('/start-writing', [
            'title' => 'My First Entry',
            'body' => 'This is a test entry body.',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('view-all-thoughts'));

        $this->assertDatabaseHas('entries', [
            'title' => 'My First Entry',
            'body' => 'This is a test entry body.',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_view_all_entries_displays_entries()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['user_id' => $user->id]);

        \App\Models\Entry::factory()->create([
            'title' => 'Entry One',
            'body' => 'Body of entry one',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        \App\Models\Entry::factory()->create([
            'title' => 'Entry Two',
            'body' => 'Body of entry two',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->get('/view-all-thoughts');

        $response->assertStatus(200);
        $response->assertSee('Entry One');
        $response->assertSee('Entry Two');
    }

    public function test_show_entry_displays_entry_details()
    {
        $this->withoutMiddleware();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $category = \App\Models\Category::factory()->create(['user_id' => $user->id]);

        $entry = \App\Models\Entry::factory()->create([
            'title' => 'Detail Test Entry',
            'body' => 'This is the full body of the test entry.',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->get("/entries/{$entry->id}");

        $response->assertStatus(200);
        $response->assertSee('Detail Test Entry');
        $response->assertSee('This is the full body of the test entry.');
    }

    public function test_edit_entry_displays_edit_form_with_existing_data()
    {
        $this->withoutMiddleware();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $category = \App\Models\Category::factory()->create(['user_id' => $user->id]);

        $entry = \App\Models\Entry::factory()->create([
            'title' => 'Entry to Edit',
            'body' => 'Original body content.',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->get("/entries/{$entry->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Entry to Edit');
        $response->assertSee('Original body content.');
    }

    public function test_update_entry_updates_data_and_redirects()
    {
        $this->withoutMiddleware();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $originalCategory = \App\Models\Category::factory()->create(['user_id' => $user->id]);
        $newCategory = \App\Models\Category::factory()->create(['user_id' => $user->id]);

        $entry = \App\Models\Entry::factory()->create([
            'title' => 'Original Title',
            'body' => 'Original body content.',
            'user_id' => $user->id,
            'category_id' => $originalCategory->id,
            'favorite' => false,
        ]);

        $response = $this->put("/entries/{$entry->id}/update", [
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
            'category_id' => $newCategory->id,
            'favorite' => true,
        ]);

        $response->assertRedirect(route('view-all-thoughts'));

        $this->assertDatabaseHas('entries', [
            'id' => $entry->id,
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
            'category_id' => $newCategory->id,
            'favorite' => true,
        ]);
    }

    public function test_delete_entry_removes_entry_and_unused_tags()
    {
        $this->withoutMiddleware();
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $category = \App\Models\Category::factory()->create(['user_id' => $user->id]);

        $entry = \App\Models\Entry::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $tag = \App\Models\Tag::factory()->create(['user_id' => $user->id]);

        $entry->tags()->attach($tag->id);

       $response = $this->delete("/entry/{$entry->id}/delete");

        $response->assertRedirect(route('view-all-thoughts'));

        $this->assertDatabaseMissing('entries', [
            'id' => $entry->id,
        ]);

        $this->assertDatabaseMissing('entry_tag', [
            'entry_id' => $entry->id,
            'tag_id' => $tag->id,
        ]);

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }


}
