<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'string|max:42',
            'content' => 'string|max:255',
            'category' => 'string|in:Task,Remider,Arrangement',
            'target' => 'date_format:Y-m-d'
        ];
    }
}
