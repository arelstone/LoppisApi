<?php

namespace App\Http\Requests\AuctionHouse;

use \App\Http\Requests\BaseRequest;


class AuctionHouseRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $exists = \App\AuctionHouse::exists($this->id);
        $user = \Auth::user();

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            return $user
                && $exists
                && $user->id === $this->route('auction_house')->user_id;
        }

        return $user;
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
