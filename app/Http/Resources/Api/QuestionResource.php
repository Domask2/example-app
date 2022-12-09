<?php

namespace App\Http\Resources\Api;

use App\Models\Categories;
use App\Models\Classification;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'key' => $this->key,
            'slug' => $this->slug,
            'category' =>  $this->category->name,
            'level' =>  $this->level->level,
            'classification' => $this->classification->classification,
            'question' => $this->question,
            'answer' => $this->answer,
            'image' => $this->image,
        ];
    }
}
