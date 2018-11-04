<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;
use App\Http\Resources\ReviewResource;

class UserResource extends BaseResource
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
            "id" => (int)$this->id,
            "name" => $this->name,
            "email" => $this->email,
            'meta' => $this->meta('users'),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
