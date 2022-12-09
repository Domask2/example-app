<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectCreateRequest extends FormRequest
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
            "title" => "",
            "key" => "",
            "description" => "",
            "is_published" => "",
            "navigation" => "",
            'project_roles' => '',
            "is_open" => "",
            "startpage" => "",
            "addictions" => "",
        ];
    }
}
