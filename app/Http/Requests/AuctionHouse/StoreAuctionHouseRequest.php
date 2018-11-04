<?php

namespace App\Http\Requests\AuctionHouse;

use \App\Http\Requests\BaseRequest;


class StoreAuctionHouseRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:255'
            ],
            'description' => [
				'nullable',
				'min:3',
				'max:255'
			],
            'address' => [
                'required',
                'min:2',
                'max:255'
            ],
            'address_co' => [
                'nullable',
                'min:2',
                'max:255'
            ],
            'zip_code' => [
                'required',
                'numeric',
                'digits:4'
            ],
            'city' => [
                'required',
                'min:2',
                'max:255',
            ],
            'country' => [
                'required',
            ],
            'email' => [
                'nullable',
                'email',
                'min:3'
            ],
            'phone' => [
                'nullable',
                'numeric',
            ],

        ];
    }
}
