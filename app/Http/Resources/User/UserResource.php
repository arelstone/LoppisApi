<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;

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
            "meta" => [
                "links" => $this->setUri('users'),
                "dates" => $this->setDates(),
            ],
        ];
    }
}
