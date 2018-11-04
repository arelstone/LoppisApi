<?php

namespace App\Http\Controllers;

use App\AuctionHouse;
use Illuminate\Http\Request;
use \App\Http\Requests\AuctionHouse\StoreAuctionHouseRequest;
use \App\Http\Requests\AuctionHouse\UpdateAuctionHouseRequest;
use \App\Http\Resources\AuctionHouseResource;

class AuctionHouseController extends Controller
{

    function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update']);
    }

    public function index()
    {
        return AuctionHouseResource::collection(AuctionHouse::paginate());
    }

    public function show(AuctionHouse $auctionHouse)
    {
        return new AuctionHouseResource($auctionHouse);
    }

    public function store(StoreAuctionHouseRequest $request)
    {
        $auctionHouse = new AuctionHouse();
        $auctionHouse->fill($request->all());
        $auctionHouse->user_id = \Auth::user()->id;
        $auctionHouse->save();

        return new AuctionHouseResource($auctionHouse);
    }

    public function update(AuctionHouse $auctionHouse, UpdateAuctionHouseRequest $request)
    {
        $auctionHouse->fill($request->all());
        $auctionHouse->save();

        return new AuctionHouseResource($auctionHouse);
    }

}
