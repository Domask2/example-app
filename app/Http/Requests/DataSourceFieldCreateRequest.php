<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataSourceFieldCreateRequest extends FormRequest
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
            'title' => 'required|max:30',
            'data_source_id' => 'exists:App\Models\DataSource,id',
            'dataIndex' => 'required|max:30',
            'key' => 'required|max:30',
            'visible' => 'required',
            'type' => 'required|max:50',
        ];
    }
}
