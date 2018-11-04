<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\RegisterResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithTokenResource;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Resources\User\UserResource
     */
    public function show($id)
    {
        $user = User::find($id);
        return new UserResource($user, $user->reviews);
    }


    /**
     * Authendicates a user
     *
     * @param  \App\Requests\User\LoginRequest $request
     * @return \App\Resources\User\UserWithTokenResource
     */
    public function login(LoginRequest $request)
    {
        $formData = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];
        if (!\Auth::attempt($formData)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = \Auth::user();
        $user->token = $this->createToken($user);
        return new UserWithTokenResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\User\RegisterRequest $request
     * @return \App\Resources\User\UserWithTokenResource
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = \Hash::make($request->password);
        $user->save();
        $user->token = $this->createToken($user);

        return new UserWithTokenResource($user);
    }

    private function createToken(User $user) {
        return $user->createToken(env('APP_NAME'))->accessToken;
    }
}
