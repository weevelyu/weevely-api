<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|unique:users,name|max:10',
            'email' => 'email|unique:users,email|max:64',
            'password' => 'min:8|confirmed'
        ];
    }
}
