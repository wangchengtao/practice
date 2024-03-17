<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $users = User::factory()->count(2)->create();

        $this->assertDatabaseCount(User::class, 2);

        $this->get(route('users.index'))
             ->assertStatus(200)
             ->assertJsonPath('data.count', 2);
    }

    public function testStore(): void
    {
        $params = [
            'name' => 'test',
            'password' => 'password',
        ];

        $this->postJson(route('users.store'), $params)
             ->assertStatus(200)
             ->assertJsonPath('code', '000000');

        $this->assertDatabaseCount(User::class, 1);
    }

    public function testShow(): void
    {
        $params = [
            'name' => 'test',
            'password' => 'password',
        ];

        $user = User::factory()->create($params);
        Topic::factory()->count(2)->for($user)->for(Category::factory())->create();


        $this->get(route('users.show', $user->id))
             ->assertStatus(200)
             ->assertJsonPath('data.name', $user->name)
            ->assertJsonCount(2, 'data.topics');
    }

}
