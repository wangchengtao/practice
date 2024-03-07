<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TopicCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(fn (TopicResource $topic) => [
            'id' => $topic->id,
            'title' => $topic->title,
            'body' => $topic->body,
            'user' => $topic->user->name,
        ])->all();
    }
}
