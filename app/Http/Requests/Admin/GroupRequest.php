<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
        $rules = [];
        switch ($this->method()) {
            case 'GET':
            case "DELETE":
                $rules = [];
                break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name' => ['required', 'max: 255'],
                    'username' => ['required', 'max: 100'],
                    'avatar' => ['required', 'mimes:jpeg,jpg,png'],
                    'cover' => ['required', 'mimes:jpeg,jpg,png'],
                    'desc_vn' => ['required'],
                    'desc_en' => ['required'],
                    'site_url' => ['nullable', 'url'],
                    'twitter_url' => ['nullable', 'url'],
                    'telegram_url' => ['nullable', 'url'],
                    'telegram_url' => ['nullable', 'url'],
                    'facebook_url' => ['nullable', 'url'],
                    'youtube_url' => ['nullable', 'url'],
                    'discord_url' => ['nullable', 'url'],
                    'instagram_url' => ['nullable', 'url'],
                ];
                break;
            default:
                break;
        }

        return $rules;
    }
}
