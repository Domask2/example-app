<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataSourceUpdateRequest extends FormRequest
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
            "title" => "max:30",
            "data_base_id" => "exists:App\Models\DataBase,id",
            "key" => "max:30",
            "endpoint" => "max:100",
            "type" => "max:10",
            "crud" => "max:4",
        ];
    }
}
