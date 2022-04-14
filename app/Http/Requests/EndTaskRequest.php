<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EndTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['required', 'image', 'max:5120'],
        ];
    }
}
