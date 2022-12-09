<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "project_id" => "required|integer",
            "key" => "required|max:50",
            "title" => "required|max:50",
            "components" => "",
            "datasources" => "",
            "ls" => "",
            "fnc" => "",
            "addictions" => "",
            "fly_inputs_groups" => "",
        ];
    }
}
