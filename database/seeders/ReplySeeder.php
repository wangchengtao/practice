<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = Topic::all();
        $users = User::all();

        Reply::factory()->count(10)->make()->each(function ($reply) use ($topics, $users) {
            $reply->topic()->associate($topics->random());
            $reply->user()->associate($users->random());
            $reply->save();
        });
    }
}
