<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $params = [
            'name' => 'test',
            'password' => 'password',
        ];

        User::factory()->create($params);

        $this->assertDatabaseCount(User::class, 1);

        $this->postJson(route('auth.login'), [
            'name' => 'test',
            'password' => 'password',
        ])->assertJsonPath('code', '000000');

        // 用户名错误
        $this->postJson(route('auth.login'), [
            'name' => 'test1',
            'password' => 'password',
        ])->assertJsonPath('code', '300000');

        // 密码错误
        $this->postJson(route('auth.login'), [
            'name' => 'test',
            'password' => 'password1',
        ])->assertJsonPath('code', '300000');
    }

    public function testMe()
    {
        $params = [
            'name' => 'test',
            'password' => 'password',
        ];

        $user = User::factory()->create($params);

        $this->assertDatabaseCount(User::class, 1);

        $this->actingAs($user)
             ->get(route('auth.me'))
             ->assertJsonPath('data.name', 'test');
    }

    // actingAs 有报错
    public function testLogout()
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount(User::class, 1);

        $this->withHeader('Authorization', 'Bearer '. auth()->login($user))
             ->delete(route('auth.logout'))
             ->assertJsonPath('code', '000000');
    }

    public function testModifyPassword()
    {
        $params = [
            'name' => 'test',
            'password' => 'admin',
        ];

        $user = User::factory()->create($params);

        $this->assertDatabaseCount(User::class, 1);

        $this->actingAs($user)
             ->patchJson(route('auth.modify-password'), [
                 'old_password' => 'admin',
                 'password' => 'password',
             ])
            ->assertJsonPath('code', '000000');

        $this->postJson(route('auth.login'), [
            'name' => 'test',
            'password' => 'password',
        ])->assertJsonPath('code', '000000');
    }
}
