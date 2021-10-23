<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginStoreRequest;
use App\Http\Requests\RegisterStoreRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(LoginStoreRequest $request)
    {
        $phone      = $request->only('phone');
        $user       = User::where('phone', $phone)->firstOrfail();

        $response   = [
            'success'   =>  true,
            'message'   =>  'Login Success',
            'token'     =>  JWTAuth::fromUser($user)
        ];

        return response()->json($response, 200);
    }

    public function register(RegisterStoreRequest $request)
    {
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'User has been created',
            'data'    => new UserResource($user),
            'token'     => JWTAuth::fromUser($user)
        ], 201);
    }
}
