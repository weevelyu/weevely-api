<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'string|max:42',
            'content' => 'string|nullable|max:255',
            'category' => 'string|in:Task,Reminder,Arrangement',
            'target' => 'date_format:Y-m-d H:i:s'
        ];
    }
}
