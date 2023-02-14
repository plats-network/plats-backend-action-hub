<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'max:' . INPUT_MAX_LENGTH, 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'name' => ['required', 'max:' . INPUT_MAX_LENGTH],
        ];
    }
}
