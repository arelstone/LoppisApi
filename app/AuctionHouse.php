<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionHouse extends Model
{
    protected $table = 'auction_houses';

    protected $fillable = [
        'name',
        'address',
        'address_co',
        'zip_code',
        'city',
        'country',
        'user_id',
        'email'
    ];


    public function user(){
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
