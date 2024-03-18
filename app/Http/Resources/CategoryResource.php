<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class CategoryResource extends JsonResource
{
    #[ResponseField('id')]
    #[ResponseField('name', 'string', '分类名称')]
    #[ResponseField('description', 'string', '分类描述')]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
