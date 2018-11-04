<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Http\Resources\User\UserResource;

class AuctionHouseResource extends BaseResource
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
            'id' => (int)$this->id,
            'name' => $this->name,
            'address' => $this->address,
            'address_co' => $this->address_co,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'country' => $this->country,
            'email' => $this->email,
            'phone' => $this->phone,
            'meta' => $this->meta('auction-houses'),
            //'user' => new UserResource($this->user),
        ];
    }
}
