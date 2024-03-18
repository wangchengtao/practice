<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class TopicResource extends JsonResource
{
    #[ResponseField('id', 'int', '话题ID')]
    #[ResponseField('title', 'string', '标题')]
    #[ResponseField('body', 'string', '内容')]
    #[ResponseField('user', 'object', '用户')]
    #[ResponseField('category', 'object', '分类')]
    #[ResponseField('reply_count', 'int', '回复数')]
    #[ResponseField('last_reply_user', 'object', '最后回复人')]
    #[ResponseField('replies', 'array', '回复列表')]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'user' => new UserResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->category),
            'reply_count' => $this->reply_count,
            'last_reply_user' => new UserResource($this->whenLoaded('lastReplyUser')),
            'replies' => ReplyResource::collection($this->whenLoaded('replies')),
        ];
    }
}
