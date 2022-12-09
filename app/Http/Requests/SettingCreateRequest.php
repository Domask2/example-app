<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingCreateRequest extends FormRequest
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
            "title" => "max:100",
            "head_styles" => "",
            "logo" => "",
            "project_key" => "max:50",
            "sys_vars" => ""
        ];
    }
}
