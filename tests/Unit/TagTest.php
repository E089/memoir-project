<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Tag;
use App\Models\Entry;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_belongs_to_a_user()
    {
        $user = User::create([
            'username' => 'taguser',
            'email' => 'taguser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $tag = Tag::create([
            'name' => 'Motivation',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $tag->user);
        $this->assertEquals($user->id, $tag->user->id);
    }

    public function test_tag_belongs_to_many_entries()
    {
        $user = User::create([
            'username' => 'taguser2',
            'email' => 'taguser2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $tag = Tag::create([
            'name' => 'Mindset',
            'user_id' => $user->id,
        ]);

        $entry1 = Entry::create([
            'title' => 'Entry One',
            'body' => 'Content for one.',
            'user_id' => $user->id,
        ]);

        $entry2 = Entry::create([
            'title' => 'Entry Two',
            'body' => 'Content for two.',
            'user_id' => $user->id,
        ]);

        $tag->entries()->attach([$entry1->id, $entry2->id]);

        $this->assertCount(2, $tag->entries);
        $this->assertTrue($tag->entries->contains($entry1));
        $this->assertTrue($tag->entries->contains($entry2));
    }
}
