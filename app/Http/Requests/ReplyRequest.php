<?php

namespace App\Http\Requests;

use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('content', 'string', '回复内容')]
class ReplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => '回复内容不能为空',
            'content.min' => '回复内容不能少于2个字符',
        ];
    }
}
