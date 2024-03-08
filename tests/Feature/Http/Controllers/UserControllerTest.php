<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
}
