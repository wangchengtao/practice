<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|between:3,25|regex:/^[\w\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
            'introduction' => 'max:80',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须在3-25个字符之间。',
            'name.required' => '用户名不能为空。',
            'email.unique' => '邮箱已被占用，请重新填写。',
            'email.email' => '邮箱格式不正确。',
            'introduction.max' => '个人简介最多80个字符。',
        ];
    }
}
