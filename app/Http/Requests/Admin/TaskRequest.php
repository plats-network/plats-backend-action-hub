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
                    'name' => ['required', 'max: 255'],
                    'description' => ['required', 'max: 100'],
                    'order' => ['required','integer'],
                    'status' => ['required'],
                    'end_at' => ['required'],
                    'start_at' => ['required'],
                    'group_id.*' => ['required'],
                    'task_socials' => ['nullable'],
                    'task_socials.*.type' => ['required'],
                    'task_socials.*.url' => ['required'],
                    'task_socials.*.amount' => ['required','numeric', 'min:0'],
                    'task_socials.*.platform' => ['required','integer'],
                    'task_socials.*.name' => ['required'],
                    'task_socials.*.reward_id' => ['required'],
                    'task_locations' => ['nullable'],
                    'task_locations.*.name' => ['required'],
                    'task_locations.*.reward_id' => ['required'],
                    'task_locations.*.description' => ['required'],
                    'task_locations.*.amount' => ['required','numeric', 'min:0'],
//                    'locations.*.job_num' => ['required','integer'],
//                    'locations.*.order' => ['required','integer'],
//                    'locations.*.status' => ['required'],
                    'task_locations.*.detail' => ['nullable'],
                    'task_locations.*.detail.*.name' => ['required'],
//                    'locations.*.detail.*.description' => ['required'],
                    'task_locations.*.detail.*.address' => ['required'],
                    'task_locations.*.detail.*.lng' => ['numeric' ],
                    'task_locations.*.detail.*.lat' => ['numeric'],
//                    'events' => ['nullable',],
//                    'events.*.name' => ['required'],
//                    'events.*.description' => ['required'],
//                    'events.*.type' => ['required'],
//                    'events.*.max_job' => ['required','numeric', 'min:0'],
//                    'events.*.status' => ['required'],
//                    'events.*.amount' => ['required','numeric', 'min:0'],
//                    'events.*.reward_id' => ['required'],
//                    'events.*.banner_url' => ['required'],
//                    'events.*.details' => ['required'],
//                    'events.*.details.*.name' => ['required'],
//                    'events.*.details.*.description' => ['required'],
//                    'events.*.details.*.status' => ['required'],
                ];
                if (!$this->id) {
                    $rules = array_merge($rules,  [
                        'banner_url' => ['nullable'],
                        'task_galleries.*' => ['nullable'],
                    ]);
                } else {
                    $rules = array_merge($rules,  [
                        'banner_url' => ['nullable',],
                        'task_galleries.*' => ['nullable',],
                    ]);
                }
                break;
            default:
                break;
        }

        return $rules;
    }
}
