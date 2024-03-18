<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class UserResource extends JsonResource
{
    #[ResponseField('id')]
    #[ResponseField('name', 'string', '用户名称')]
    #[ResponseField('email', 'string', '用户邮箱')]
    #[ResponseField('avatar', 'string', '用户头像')]
    #[ResponseField('introduction', 'string', '用户简介')]
    #[ResponseField('phone', 'string', '用户电话号码')]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'introduction' => $this->introduction,
            'phone' => $this->phone,
            'topics' => new TopicCollection($this->whenLoaded('topics')),
            'replies' => ReplyResource::collection($this->whenLoaded('replies')),
        ];
    }
}
