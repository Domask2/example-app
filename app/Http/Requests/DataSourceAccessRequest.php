<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataSourceAccessRequest extends FormRequest
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
            "data_source_id" => "required",
            "key" => "exists:App\Models\DataSource,key",
            "source_name" => "required|max:50",
            "role" => "required|max:15"
        ];
    }
}
