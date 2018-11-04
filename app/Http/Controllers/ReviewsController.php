<?php

namespace App\Http\Controllers;

use App\Reviews;
use App\AuctionHouse;
use Illuminate\Http\Request;
use App\Http\Requests\AuctionHouse\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\AuctionHouseResource;

class ReviewsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:api')->only(['store']);
    }

    public function index($id) {
        $reviews = Reviews::where('auction_house_id', $id)->paginate();

        return ReviewResource::collection($reviews);
    }

    public function store($id, ReviewRequest $request)
    {
        $review = new Reviews();
        $resource = $review->where('auction_house_id', $id)->where('user_id', $request->user()->id);

        if ($resource->exists()) {
            return $this->updateReview($resource->first(), $request);
        }

        $review->fill($request->all());
        $review->user_id = $request->user()->id;
        $review->auction_house_id = $id;
        $review->save();

        return new AuctionHouseResource($review->auctionHouse);
    }

    private function updateReview($review, ReviewRequest $request){
        $review->fill($request->all());
        $review->save();

        return new AuctionHouseResource($review->auctionHouse);

    }

}
