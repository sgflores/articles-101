<?php

namespace App\Http\Resources;

use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
        if ($this->relationLoaded('articles')) {
            $data['articles'] = $this->articles->map(function($article) {
                return new ArticleResource($article);
            });
        }
        return $data;
    }
}
