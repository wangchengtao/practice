<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'category' => new CategoryResource($this->category),
            'reply_count' => $this->reply_count,
            'last_reply_user' => new UserResource($this->whenLoaded('lastReplyUser')),
            'replies' => new UserCollection($this->replies),
        ];
    }
}
