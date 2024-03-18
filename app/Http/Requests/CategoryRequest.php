<?php

namespace App\Http\Requests;

use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('name', 'string', '分类名称')]
#[BodyParam('description', 'string', '分类描述')]
class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|between:1,10',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '分类名不能为空',
            'name.between' => '分类名必须在1-10个字符之间',
            'description.required' => '分类描述不能为空',
        ];
    }
}
