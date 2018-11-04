<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function meta($uri)
    {
        return [
            "links" => $this->setUri($uri),
            "dates" => $this->setDates(),
        ];
    }

    public function setUri($uri)
    {
        return [
            'self' => env('APP_URL') . '/api/' . $uri . '/' . $this->id
        ];
    }

    public function setDates()
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
