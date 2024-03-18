<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Knuckles\Scribe\Attributes\ResponseField;

class TopicCollection extends ResourceCollection
{
    #[ResponseField('id', 'int', '话题ID')]
    #[ResponseField('title', 'string', '标题')]
    #[ResponseField('body', 'string', '内容')]
    #[ResponseField('user', 'object', '用户')]
    public function toArray(Request $request): array
    {
        return $this->collection->map(fn (TopicResource $topic) => [
            'id' => $topic->id,
            'title' => $topic->title,
            'body' => $topic->body,
            'user' => $topic->whenLoaded('user', function () use ($topic) {
                return $topic->user->name;
            }),
        ])->all();
    }
}
