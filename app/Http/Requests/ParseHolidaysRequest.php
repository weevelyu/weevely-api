<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParseHolidaysRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country' => 'alpha',
            'year' => 'integer|min:2020|max:9999',
        ];
    }
}
