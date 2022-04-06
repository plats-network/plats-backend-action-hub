<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'max:' . INPUT_MAX_LENGTH],
            'image'         => ['image'],
            'reward_amount' => ['numeric', 'min:0'],
            'exc_time'      => ['integer', 'min:0'],
            'long'          => ['numeric', 'max:' . INPUT_MAX_LENGTH],
            'last'          => ['numeric', 'max:' . INPUT_MAX_LENGTH],
        ];
    }
}
