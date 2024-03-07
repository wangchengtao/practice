<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->fill($request->validated());

        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();

        return $this->success();
    }

    public function show(Reply $reply)
    {
        return $this->success(new ReplyResource($reply->load('user')));
    }

    public function update(ReplyRequest $request, Reply $reply)
    {
        $reply->update($request->validated());

        return $this->success();
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();

        return $this->success();
    }
}
