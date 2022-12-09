<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataSourceFieldUpdateRequest extends FormRequest
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
            'title' => 'max:50',
            'data_source_id' => 'exists:App\Models\DataSource:id',
            'dataIndex' => 'max:50',
            'key' => 'max:50',
            'visible' => 'boolean',
            'pk' => 'boolean',
            'search' => 'boolean',
            'type' => 'max:50',
        ];
    }
}
