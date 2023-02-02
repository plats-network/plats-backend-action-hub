<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            case 'PUT':
                break;
            case 'POST':
                $rules = [
                    'base.name' => ['required', 'max: 255'],
                    'base.description' => ['required', 'max: 100'],
                    'base.order' => ['required','integer'],
                    'base.status' => ['required'],
                    'base.group_id.*' => ['required'],
                    'social' => ['nullable'],
                    'social.*.type' => ['required'],
                    'social.*.url' => ['required'],
                    'social.*.amount' => ['required','numeric', 'min:0'],
                    'social.*.platform' => ['required','integer'],
                    'social.*.name' => ['required'],
                    'social.*.reward_id' => ['required'],
                    'locations' => ['nullable'],
                    'locations.*.name' => ['required'],
                    'locations.*.reward_id' => ['required'],
                    'locations.*.description' => ['required'],
                    'locations.*.amount' => ['required','numeric', 'min:0'],
                    'locations.*.job_num' => ['required','integer'],
                    'locations.*.order' => ['required','integer'],
                    'locations.*.status' => ['required'],
                    'locations.*.detail' => ['nullable'],
                    'locations.*.detail.*.name' => ['required'],
                    'locations.*.detail.*.description' => ['required'],
                    'locations.*.detail.*.address' => ['required'],
                    'locations.*.detail.*.lng' => ['numeric', 'max:' . INPUT_MAX_LENGTH],
                    'locations.*.detail.*.lat' => ['numeric', 'max:' . INPUT_MAX_LENGTH],
                    'events' => ['nullable',],
                    'events.*.name' => ['required'],
                    'events.*.description' => ['required'],
                    'events.*.type' => ['required'],
                    'events.*.max_job' => ['required','numeric', 'min:0'],
                    'events.*.status' => ['required'],
                    'events.*.amount' => ['required','numeric', 'min:0'],
                    'events.*.reward_id' => ['required'],
                    'events.*.banner_url' => ['required'],
                    'events.*.details' => ['required'],
                    'events.*.details.*.name' => ['required'],
                    'events.*.details.*.description' => ['required'],
                    'events.*.details.*.status' => ['required'],
                ];
                if (!$this->id) {
                    $rules = array_merge($rules,  [
                        'image' => ['nullable', 'mimes:jpeg,jpg,png'],
                        'slider.*' => ['nullable', 'mimes:jpeg,jpg,png'],
                    ]);
                } else {
                    $rules = array_merge($rules,  [
                        'image' => ['nullable',],
                        'slider.*' => ['nullable',],
                    ]);
                }
                break;
            default:
                break;
        }

        return $rules;
    }
}
