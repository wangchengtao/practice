<?php

namespace App\Http\Requests;

use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('title', 'string', '标题')]
#[BodyParam('body', 'string', '内容')]
#[BodyParam('category_id', 'integer', '分类ID')]
class TopicRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'body' => 'required|min:3',
            'category_id' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能少于3个字符',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能少于3个字符',
            'category_id.required' => '分类不能为空',
            'category_id.numeric' => '分类必须为数字',
        ];
    }
}
