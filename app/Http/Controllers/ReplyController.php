<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Topic;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Group('Reply', '评论')]
class ReplyController extends Controller
{
    #[Endpoint('创建')]
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->fill($request->validated());

        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();

        return $this->success();
    }

    #[Endpoint('详情')]
    #[ResponseFromFile('responses/reply/reply.json')]
    #[ResponseFromApiResource(ReplyResource::class, Reply::class)]
    public function show(Reply $reply)
    {
        return $this->success(new ReplyResource($reply->load('user')));
    }

    #[Endpoint('更新')]
    public function update(ReplyRequest $request, Reply $reply)
    {
        $reply->update($request->validated());

        return $this->success();
    }

    #[Endpoint('删除')]
    public function destroy(Reply $reply)
    {
        $reply->delete();

        return $this->success();
    }
}
