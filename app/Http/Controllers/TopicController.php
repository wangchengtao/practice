<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Group('Topic', '话题')]
class TopicController extends Controller
{
    #[Endpoint('列表')]
    #[ResponseFromFile('responses/topic/index.json')]
    #[ResponseFromApiResource(TopicCollection::class, Topic::class, paginate: 10)]
    public function index(Request $request)
    {
        $topics = Topic::filter($request->all())->with('user')->paginate(10);

        return $this->paginate(new TopicCollection($topics));
    }

    #[Endpoint('创建')]
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->validated());

        $topic->user()->associate($request->user());
        $topic->save();

        return $this->success();
    }

    #[Endpoint('详情')]
    #[ResponseFromFile('responses/topic/topic.json')]
    #[ResponseFromApiResource(TopicResource::class, Topic::class)]
    public function show(Topic $topic)
    {
        return $this->success(new TopicResource($topic->load('user', 'replies', 'lastReplyUser')));
    }

    #[Endpoint('更新')]
    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->update($request->validated());

        return $this->success();
    }

    #[Endpoint('删除')]
    public function destroy(Topic $topic)
    {
        $topic->replies()->delete();
        $topic->delete();

        return $this->success();
    }
}
