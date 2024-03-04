<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        Category::factory()->count(2)->create();

        $this->assertDatabaseCount(Category::class, 2);

        $this->get(route('categories.index'))
             ->assertStatus(200)
             ->assertJsonPath('data.count', 2);
    }

    public function testStore()
    {
        $params = [
            'name' => 'test',
            'description' => 'test',
        ];

        $this->postJson(route('categories.store'), $params)
            ->assertStatus(200);

        $this->assertDatabaseCount(Category::class, 1);
    }

    public function testShow()
    {
        $params = [
            'name' => 'test',
            'description' => 'test',
        ];

        $category = Category::factory()->create($params);

        $this->assertDatabaseCount(Category::class, 1);

        $this->get(route('categories.show', $category->id))
            ->assertStatus(200)
            ->assertJsonPath('data.name', $params['name']);
    }

    public function testUpdate()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseCount(Category::class, 1);

        $params = [
            'name' => 'test',
            'description' => 'test',
        ];

        $this->putJson(route('categories.update', $category->id), $params)
            ->assertStatus(200);

        $category->refresh();

        $this->assertEquals($params['name'], $category->name);
    }

    public function testDestroy()
    {
        $category = Category::factory()
            ->has(Topic::factory()
                       ->count(2)
                       ->for(User::factory())
            )
            ->create();

        $this->assertDatabaseCount(Category::class, 1);

        $this->delete(route('categories.destroy', $category->id))
            ->assertStatus(200);

        $this->assertModelMissing($category);
        $this->assertDatabaseMissing(Topic::class, ['id' => $category->id]);
    }
}
