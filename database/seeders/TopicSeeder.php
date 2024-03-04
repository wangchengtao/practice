<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();

        Topic::factory()->count(15)->make()->each(function (Topic $topic) use ($categories, $users) {
            $topic->category()->associate($categories->random());
            $topic->user()->associate($users->random());
            $topic->save();
        });
    }
}
