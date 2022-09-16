<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'type'                              => ['integer', 'between:'. CHECKIN . ',' . SUBSCRIBE_AND_INTERACT],
            'name'                              => ['required', 'max:' . INPUT_MAX_LENGTH],
            'description'                       => ['max:' . INPUT_MAX_LENGTH],
            'duration'                          => ['integer', 'min:1'],
            'order'                             => ['integer', Rule::in([OUT_OF_ORDER, IN_ORDER])],
            'valid_amount'                      => ['required', 'min:1'],
            'image'                             => ['image'],
            'rewards'                           => ['array'],
            'rewards.*.reward_id'               => ['max:' . INPUT_MAX_LENGTH],
            'rewards.*.amount'                  => ['max:' . INPUT_MAX_LENGTH],
            'locations'                         => ['required', 'array'],
            'locations.*.name'                  => ['required', 'max:' . INPUT_MAX_LENGTH],
            'locations.*.phone_number'          => ['numeric', 'digits:10'],
            'locations.*.open_time'             => ['date_format:H:i'],
            'locations.*.close_time'            => ['date_format:H:i, after:open_time'],
            'locations.*.coordinate'            => ['required', 'max:' . INPUT_MAX_LENGTH],
            'locations.*.lat'                   => ['numeric', 'between:-90,90'],
            'locations.*.long'                  => ['numeric', 'between:-180,180'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'locations.*.phone_number.numeric'           => ':attribute #:position must be numeric',
            'locations.*.phone_number.digits'            => ':attribute #:position must be digits',
            'locations.*.lat.numeric'                    => ':attribute #:position must be numeric',
            'locations.*.lat.between'                    => ':attribute #:position must be between -180, 180',
            'locations.*.long.numeric'                   => ':attribute #:position must be 10 numeric',
            'locations.*.long.between'                   => ':attribute #:position must be between -180, 180',
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
            'valid_amount'                      => 'valid amount',
            'rewards.*.reward_id'               => 'rewards',
            'rewards.*.amount'                  => 'rewards amount',
            'locations'                         => 'locations',
            'locations.*.phone_number'          => 'location phone number',
            'locations.*.open_time'             => 'location open time',
            'locations.*.close_time'            => 'location close time',
            'locations.*.coordinate'            => 'location coordinate',
            'locations.*.lat'                   => 'latitude',
            'locations.*.long'                  => 'longitude',
        ];
    }
}
