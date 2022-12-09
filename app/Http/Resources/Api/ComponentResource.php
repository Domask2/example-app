<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
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
            'id' => $this->id,
            'part' => $this->part,
            'key' => $this->key,
            'type' => $this->type,
            'props' => $this->props,
            'style' => $this->style,
            'sett' => $this->sett,
        ];
    }
}
