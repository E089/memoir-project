<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;
use App\Models\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_belongs_to_a_user()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $tag->user);
        $this->assertEquals($user->id, $tag->user->id);
    }

    public function test_tag_belongs_to_many_entries()
    {
        $user = User::factory()->create();

        $tag = Tag::factory()->create([
            'user_id' => $user->id,
        ]);

        $entry1 = Entry::factory()->create(['user_id' => $user->id]);
        $entry2 = Entry::factory()->create(['user_id' => $user->id]);

        $tag->entries()->attach([$entry1->id, $entry2->id]);

        $tag->refresh();

        $this->assertCount(2, $tag->entries);
        $this->assertTrue($tag->entries->contains($entry1));
        $this->assertTrue($tag->entries->contains($entry2));
    }
}
