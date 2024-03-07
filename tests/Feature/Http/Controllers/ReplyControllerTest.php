<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReplyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Topic $topic;

    public function setUp(): void
    {
        parent::setUp();

        $this->topic = Topic::factory()
                            ->for(User::factory())
                            ->for(Category::factory())
                            ->create();
    }

    public function testStore()
    {
        $params = [
            'content' => 'test',
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
             ->postJson(route('replies.store', $this->topic->id), $params)
            ->assertStatus(200);

        $this->assertDatabaseCount(Reply::class, 1);
    }

    public function testShow()
    {
        $reply = Reply::factory()
                      ->for($this->topic)
                      ->for(User::factory())
                      ->create([
                          'content' => 'test',
                      ]);

        $this->assertDatabaseCount(Reply::class, 1);

        $this->get(route('replies.show', $reply->id))
             ->assertStatus(200)
             ->assertJsonPath('data.content', 'test');
    }

    public function testUpdate()
    {
        $reply = Reply::factory()
                      ->for($this->topic)
                      ->for(User::factory())
                      ->create();

        $this->assertDatabaseCount(Reply::class, 1);

        $params = [
            'content' => 'test',
        ];

        $this->putJson(route('replies.update', $reply->id), $params)
             ->assertStatus(200);

        $reply->refresh();

        $this->assertEquals($params['content'], $reply->content);
    }

    public function testDestroy()
    {
        $reply = Reply::factory()
                      ->for($this->topic)
                      ->for(User::factory())
                      ->create();

        $this->assertDatabaseCount(Reply::class, 1);

        $this->delete(route('replies.destroy', $reply->id))
             ->assertStatus(200);

        $this->assertDatabaseCount(Reply::class, 0);
    }
}
