<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;

class ReviewResource extends BaseResource
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
            'rating' => $this->rating,
            'review' => $this->review,
            'user' => new UserResource($this->user),
            'auctionHouse' => new AuctionHouseResource($this->auctionHouse),
            'meta' => [
                'dates' => $this->setDates()
            ],
        ];
    }
}
