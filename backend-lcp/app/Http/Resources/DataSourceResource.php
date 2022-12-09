<?php

namespace App\Http\Resources;

use App\Models\DataSourceAccess;
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
            "title" =>  $this->title,
            "key" =>  $this->key,
            "description" => $this->description,
            "type" =>  $this->type,
            "dataSourceFields" => DataSourceFieldsResource::collection($this->dataSourceFields->sortBy(['title', 'key'])),
            "dataSourceAccess" => DataSourceAccessResource::collection(DataSourceAccess::where('data_source_id', $this->id)->get()),
        ];
    }
}
