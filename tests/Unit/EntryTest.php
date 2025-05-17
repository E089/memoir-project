<?php

namespace Tests\Unit;

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
        $user = User::create([
            'username' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
        ]);

        $entry = Entry::create([
            'title' => 'Test Entry',
            'body' => 'Body content',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $entry->user);
        $this->assertEquals($user->id, $entry->user->id);
    }

    public function test_entry_belongs_to_a_category()
    {
        $user = User::create([
            'username' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create([
            'name' => 'Work',
            'description' => 'Work stuff',
            'user_id' => $user->id,
        ]);

        $entry = Entry::create([
            'title' => 'Work Entry',
            'body' => 'Body content',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Category::class, $entry->category);
        $this->assertEquals($category->id, $entry->category->id);
    }

    public function test_entry_can_have_tags()
    {
        $user = User::create([
            'username' => 'tester',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
        ]);

        $entry = Entry::create([
            'title' => 'Tagged Entry',
            'body' => 'Some thoughts...',
            'user_id' => $user->id,
        ]);

        $tag1 = Tag::create(['name' => 'Inspiration', 'user_id' => $user->id]);
        $tag2 = Tag::create(['name' => 'Life', 'user_id' => $user->id]);

        $entry->tags()->attach([$tag1->id, $tag2->id]);

        $entry->refresh(); // reload relationships

        $this->assertCount(2, $entry->tags);
        $this->assertTrue($entry->tags->contains($tag1));
        $this->assertTrue($entry->tags->contains($tag2));
    }
}
