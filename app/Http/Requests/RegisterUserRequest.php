<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'age' => 'required|integer',
            'name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.unique' => 'Địa chỉ email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'age.required' => 'Vui lòng nhập tuổi',
            'age.number' => 'Tuổi không hợp lệ',
            'name.required' => 'Vui lòng nhập tên',
            'name.string' => 'Tên không hợp lệ',
        ];
    }
}
