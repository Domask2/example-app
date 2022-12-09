<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'title' => $this->title,
            'head_styles' => json_decode($this->head_styles),
            'logo' => $this->logo,
            'project_key' => $this->project_key,
            'sys_vars' => json_decode($this->sys_vars),
        ];
    }
}
