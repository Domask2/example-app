<?php

namespace App\Http\Resources\Api;

use App\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'key' => $this->key,
            'description' => $this->description,
            'is_published' => $this->is_published,
            'navigation' => json_decode($this->navigation),
            'project_roles' => json_decode($this->project_roles),
            'is_open' => $this->is_open,
            'startpage' => $this->startpage,
            'addictions' => json_decode($this->addictions),
            'banner' => $this->banner,
            'logo' => $this->logo,
            'pages' => Page::where('project_id', $this->id)->get()
        ];
    }
}
