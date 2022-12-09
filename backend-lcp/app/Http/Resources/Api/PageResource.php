<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "key" => "/" . $this->project->key . "/". $this->key,
            "description" => $this->description,
            "components" => json_decode($this->components),
            "datasources" => json_decode($this->datasources),
            "ls" => json_decode($this->ls),
            "fnc" => json_decode($this->fnc),
            "addictions" => json_decode($this->addictions),
            "fly_inputs_groups" => json_decode($this->fly_inputs_groups),
        ];
    }
}
