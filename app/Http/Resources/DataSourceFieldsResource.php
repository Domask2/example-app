<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSourceFieldsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $key = substr($this->key, 0, 2) === '__' ? substr($this->key, 2) : $this->key;

        return [
            "title" => $this->title,
//            "dataIndex" => $this->dataIndex,
            "dataIndex" => $key,
            "key" =>  $key,
            "visible" =>  $this->visible,
            "pk" =>  $this->pk,
            "search" =>  $this->search,
            "type" =>  $this->type,
        ];
    }
}
