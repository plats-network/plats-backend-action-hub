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
            'name'                => ['required', 'max:' . INPUT_MAX_LENGTH],
            'description'         => ['max:' . INPUT_MAX_LENGTH],
            'duration'            => ['integer', 'min:1'],
            'distance'            => ['numeric', 'min:0'],
            'reward_amount'       => ['numeric', 'min:0'],
            'image'               => ['image'],
            'location'            => ['required', 'array'],
            'location.*.name'       => ['required', 'max:' . INPUT_MAX_LENGTH],
            'location.*.coordinate' => ['required', 'max:' . INPUT_MAX_LENGTH],
        ];
    }
}
