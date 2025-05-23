<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Entry;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntryTest extends TestCase
{
    use RefreshDatabase;

    public function test_entry_belongs_to_a_user()
    {
        $user = User::factory()->create();

        $entry = Entry::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $entry->user);
        $this->assertEquals($user->id, $entry->user->id);
    }

    public function test_entry_belongs_to_a_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $entry = Entry::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Category::class, $entry->category);
        $this->assertEquals($category->id, $entry->category->id);
    }

    public function test_entry_can_have_tags()
    {
        $user = User::factory()->create();

        $entry = Entry::factory()->create([
            'user_id' => $user->id,
        ]);

        $tag1 = Tag::factory()->create(['user_id' => $user->id]);
        $tag2 = Tag::factory()->create(['user_id' => $user->id]);

        $entry->tags()->attach([$tag1->id, $tag2->id]);
        $entry->refresh();

        $this->assertCount(2, $entry->tags);
        $this->assertTrue($entry->tags->contains($tag1));
        $this->assertTrue($entry->tags->contains($tag2));
    }
}
