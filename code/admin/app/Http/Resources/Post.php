<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'id' => $this->resource['id'],
            'title' => $this->resource['title'],
            'slug' => $this->resource['slug'],
            'body' => $this->resource['body'],
            'image' => $this->resource['image'],
            'published' => $this->resource['published'],
            'author_id' => $this->resource['author_id']
        ];
    }
}
