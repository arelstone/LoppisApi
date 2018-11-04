<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BaseResource;

class UserWithTokenResource extends BaseResource
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
            "id" => (int) $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "token" => $this->token
        ];
    }
}
