<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
//            "id" => $this->id,
//            "data_base_id" =>  $this->data_base_id,
            "title" =>  $this->title,
            "key" =>  $this->key,
            "description" => $this->description,
            "type" =>  $this->type,
//            "crud" =>  $this->crud,
//            "created_at" =>  $this->created_at,
//            "updated_at" =>  $this->updated_at,
            "dataSourceFields" => DataSourceFieldsResource::collection($this->dataSourceFields),
        ];
    }
}
