<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TweetEnum;
// use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SocialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string', new Enum(TweetEnum::class)],
        ];
    }
}
