<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataBaseCreateRequest extends FormRequest
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
            "title"     => "max:30",
            "key"       => "max:50",
            "driver"    => "",
            "host"      => "",
            "port"      => "integer",
            "database"  => "",
            "username"  => "",
            "password"  => "",
            "charset"   => "",
            "prefix"    => "",
            "prefix_indexes" => "",
            "schema"    => "",
            "sslmode"   => "",
            "url"       => "",
            "description"   => "max:255",
        ];
    }
}
