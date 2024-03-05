<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        Topic::factory()
             ->count(2)
             ->for(Category::factory())
             ->for(User::factory())
             ->create();

        $this->assertDatabaseCount(Topic::class, 2);

        $this->get(route('topics.index'))
            ->assertStatus(200)
            ->assertJsonPath('data.count', 2);
    }

    public function testIndexByQuery(): void
    {
        Topic::factory()
             ->count(10)
             ->for(User::factory())
            ->sequence(
                ['title' => 'laravel', 'category_id' => 1],
                ['title' => 'java', 'category_id' => 2],
                ['title' => 'go', 'category_id' => 1],
            )
             ->create();

        $params = [
            'title' => 'laravel',
        ];

        $this->getJson(route('topics.index', $params))
            ->assertStatus(200)
            ->assertJsonCount(4, 'data.list');

        $params = [
            'category_id' => 1,
        ];

        $this->getJson(route('topics.index', $params))
             ->assertStatus(200)
             ->assertJsonCount(7, 'data.list');

        $params = [
            'title' => 'laravel',
            'category_id' => 1,
        ];

        $this->getJson(route('topics.index', $params))
             ->assertStatus(200)
             ->assertJsonCount(4, 'data.list');
    }

    public function testStore(): void
    {
        $params = [
            'title' => 'test',
            'body' => 'this is body content',
            'category_id' => 1,
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
             ->postJson(route('topics.store'), $params)
            ->assertStatus(200);

        $this->assertDatabaseCount(Topic::class, 1);
    }

    public function testShow(): void
    {
        $params = [
            'title' => 'test',
            'body' => 'this is body content',
        ];

        $topic = Topic::factory()
                      ->for(User::factory())
                      ->for(Category::factory())
                      ->create($params);

        $this->assertDatabaseCount(Topic::class, 1);
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseCount(User::class, 1);

        $this->get(route('topics.show', $topic->id))
            ->assertStatus(200)
            ->assertJsonPath('data.title', $params['title']);
    }

    public function testUpdate(): void
    {
        $topic = Topic::factory()
                      ->for(User::factory())
                      ->for(Category::factory())
                      ->create();

        $params = [
            'title' => 'test',
            'body' => 'this is body content',
            'category_id' => 1,
        ];

        $this->putJson(route('topics.update', $topic->id), $params)
            ->assertStatus(200);

        $topic->refresh();

        $this->assertEquals($params['title'], $topic->title);
    }

    public function testDestroy(): void
    {
        $topic = Topic::factory()
                      ->for(User::factory())
                      ->for(Category::factory())
                      ->has(Reply::factory()->count(2))
                      ->create();

        $this->assertDatabaseCount(Topic::class, 1);
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Reply::class, 2);

        $this->delete(route('topics.destroy', $topic->id))
            ->assertStatus(200);

        $this->assertModelMissing($topic);
        $this->assertDatabaseEmpty(Reply::class);
    }

}
