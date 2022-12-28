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
                $rules = [
                    'name'   => ['required', 'unique:groups', 'max: 255'],
                    'seo_image'     => 'required|mimes:jpeg,jpg,png'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'category_id'   => 'required',
                    'name'          => 'required|max:255',
                    'description'   => 'required|max:255',
                    'content'       => 'required'
                ];
                break;
            default:
                break;
        }

        return $rules;
    }
}
