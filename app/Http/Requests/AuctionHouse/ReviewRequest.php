<?php

namespace App\Http\Requests\AuctionHouse;

use App\Http\Requests\BaseRequest;

class ReviewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('auction_house');
        $user = \Auth::user();
        $auctionHouse = \App\AuctionHouse::findOrFail($id);

        return $user
            && $auctionHouse->user_id !== $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'rating' => 'required|numeric|max:5|min:1',
                'review' => 'nullable|max:255'

        ];
    }
}
