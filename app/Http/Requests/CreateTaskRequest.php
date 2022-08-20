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
            'valid_amount'        => ['required', 'min:1'],
            'image'               => ['image'],
            'rewards'              => ['required', 'array'],
            'rewards.*.reward_id'  => ['required', 'max:' . INPUT_MAX_LENGTH],
            'rewards.*.amount'     => ['required', 'max:' . INPUT_MAX_LENGTH],
            'locations'            => ['required', 'array'],
            'locations.*.name'       => ['required', 'max:' . INPUT_MAX_LENGTH],
            'locations.*.coordinate' => ['required', 'max:' . INPUT_MAX_LENGTH],
        ];
    }
}
