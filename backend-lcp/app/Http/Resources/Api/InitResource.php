<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\DataBaseResource;
use App\Http\Resources\DataSourceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'projects' => ProjectResource::collection($this->resource['projects']),
            'components' => ComponentResource::collection($this->resource['components']),
            'setting' => SettingResource::collection($this->resource['setting']),
            'db' => DataBaseResource::collection($this->resource['db']),
        ];
    }
}
