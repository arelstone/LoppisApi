<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function setUri($uri)
    {
        return [
            'self' => env('APP_URL') . '/api/' . $uri . '/' . $this->id
        ];
    }

    public function setDates(){
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
