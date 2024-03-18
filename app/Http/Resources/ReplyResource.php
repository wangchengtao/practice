<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class ReplyResource extends JsonResource
{
    #[ResponseField('id', 'int', '回复ID')]
    #[ResponseField('content', 'string', '回复内容')]
    #[ResponseField('user', 'object', '回复用户')]
    #[ResponseField('created_at', 'string', '创建时间')]
    #[ResponseField('updated_at', 'string', '更新时间')]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
