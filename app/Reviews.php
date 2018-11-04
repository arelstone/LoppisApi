<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'rating',
        'review'
    ];

    public function auctionHouse(){
        return $this->belongsTo('\App\AuctionHouse', 'auction_house_id');
    }

    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }

}
