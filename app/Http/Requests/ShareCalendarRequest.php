<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareCalendarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'users' => 'required|json'
        ];
    }
}
