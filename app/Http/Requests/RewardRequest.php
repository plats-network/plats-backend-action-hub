<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RewardRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:' . INPUT_MAX_LENGTH],
            'description' => ['required', 'max:' . INPUT_MAX_LENGTH],
            'image' => ['required', 'string'],
            'type' => ['required', 'integer', 'in: [0,1,2,3]'],
            'start_at' => ['required'],
            'end_at' => ['required'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'logo_path' => 'Logo image',
        ];
    }
}
