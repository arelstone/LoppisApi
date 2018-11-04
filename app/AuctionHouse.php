<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionHouse extends Model
{
    protected $table = 'auction_houses';

    protected $fillable = [
        'name',
        'address',
        'desctiption',
        'address_co',
        'zip_code',
        'city',
        'country',
        'user_id',
        'email'
    ];

    public static function rating($id){
        return Reviews::where('auction_house_id', $id)->get()->avg('rating');
    }

    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function reviews(){
        return $this->hasMany('\App\Reviews', 'auction_house_id');
    }
}
