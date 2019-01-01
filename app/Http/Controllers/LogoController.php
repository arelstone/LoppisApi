<?php

namespace App\Http\Controllers;

use App\Logo;
use App\Http\Requests\AuctionHouse\LogoRequest;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogoRequest $request)
    {
        $auctionHouseId = $request->route('auction_house');
        $path = 'logos/auction_houses/'.$auctionHouseId;

        $this->cleanUp($auctionHouseId);

        $md5Name = md5_file($request->file('file')->getRealPath());
        $guessExtension = $request->file('file')->guessExtension();
        $filename = $md5Name.'.'.$guessExtension;

        $file = $request->file('file')->storeAs($path, $filename);

        $data = [
            'auction_house_id' => $auctionHouseId,
            'user_id' => \Auth::user()->id,
            'filename' => $filename
        ];

        Logo::create($data);

        return response()->json([
            'message' => 'successfull uploaded'
        ]);
    }

    /**
     * Show a logo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        $auctionHouseId = $request->route('auction_house');
        $logo = Logo::where('auction_house_id', $auctionHouseId)->first();

        return response()->download(storage_path('app/logos/auction_houses/'.$auctionHouseId.'/' . $logo->filename));
    }


    private function cleanUp($auctionHouseId){
        $path = 'logos/auction_houses/'.$auctionHouseId;

        \Storage::allFiles($path);
        Logo::where('auction_house_id', $auctionHouseId)->delete();
    }
}
