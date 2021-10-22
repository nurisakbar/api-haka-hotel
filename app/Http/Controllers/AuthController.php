<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginStoreRequest;
use App\Http\Requests\RegisterStoreRequest;

class AuthController extends Controller
{
    public function login(LoginStoreRequest $request)
    {
        $phone = $request->only('phone');
        $user  = User::where('phone', $phone)->firstOrfail();
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'), 200);
    }

    public function register(RegisterStoreRequest $request)
    {
        $request['password'] = Hash::make($request->get('password'));
        $user = User::create($request->all());

        return response()->json([
            'message' => 'User has been created',
            'user'    => $user
        ], 201);
    }
}
