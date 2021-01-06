<?php

namespace App\Http\Resources;

use App\Http\Resources\Client as ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'required_word_count' => $this->required_word_count,
            'client_id' => $this->client_id,
        ];
        if ($this->relationLoaded('client')) {
            $data['client'] = new ClientResource($this->client);
        }
        return $data;
    }
}
