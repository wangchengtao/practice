<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $topics = Topic::filter($request->all())->paginate(10);

        return $this->paginate(new TopicCollection($topics));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->validated());

        $topic->user()->associate($request->user());
        $topic->save();

        return $this->success();
    }

    public function show(Topic $topic)
    {
        return $this->success(new TopicResource($topic->load('replies', 'lastReplyUser')));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->update($request->validated());

        return $this->success();
    }

    public function destroy(Topic $topic)
    {
        $topic->replies()->delete();
        $topic->delete();

        return $this->success();
    }
}
