<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'email' => $this->email,
            'theme' => $this->theme,
            'header_type' => $this->header_type,
//            'projects_roles' => json_decode($this->projects_roles)
            'projects_roles' => is_null($this->projects_roles) ? [] : get_object_vars(json_decode($this->projects_roles))
        ];
    }
}
