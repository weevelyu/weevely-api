<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:users,name|max:10',
            'email' => 'required|email|unique:users,email|max:64',
            'password' => 'required|min:8|confirmed'
        ];
    }
}
