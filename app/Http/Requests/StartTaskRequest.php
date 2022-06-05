<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wallet_address' => ['required', 'max:' . INPUT_MAX_LENGTH],
        ];
    }
}
