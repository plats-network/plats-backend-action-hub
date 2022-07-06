<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'               => ['required', 'max:' . INPUT_MAX_LENGTH],
            'content'             => ['required', 'max:' . INPUT_MAX_LENGTH],
            'data'                => ['required', 'max:' . INPUT_MAX_LENGTH],
        ];
    }
}
