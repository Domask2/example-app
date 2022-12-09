<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataBaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (auth()->user()->role === 'admin')
            return [
                "id" => $this->id,
                "title" => $this->title,
                "key" => $this->key,
                "dataSources" => DataSourceResource::collection($this->dataSources->sortBy(['type', 'key'])),
                "driver" => $this->driver,
                "host" => $this->host,
                "port" => $this->port,
                "database" => $this->database,
                "username" => $this->username,
                "password" => $this->password,
                "charset" => $this->charset,
                "prefix" => $this->prefix,
                "prefix_indexes" => $this->prefix_indexes,
                "schema" => $this->schema,
                "sslmode" => $this->sslmode,
                "url" => $this->url,
                "description" => $this->description
            ];
        else
            return [
                "title" => $this->title,
                "key" => $this->key,
                "dataSources" => DataSourceResource::collection($this->dataSources),
            ];
    }
}
