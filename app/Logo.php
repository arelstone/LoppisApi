<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $fillable = [
        'auction_house_id',
        'user_id',
        'filename'
    ];
}
