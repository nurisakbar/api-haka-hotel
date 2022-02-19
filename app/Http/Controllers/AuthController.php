<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginStoreRequest;
use App\Http\Requests\RegisterStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\AccountVerify;
use Illuminate\Http\Request;

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

        $generateNumber = rand(pow(10, 4 - 1), pow(10, 4) - 1);
        $message = "Your verification code is $generateNumber";
        $phone_number = $request->phone;
        $message_type = "text";
        $device_id = "redmi-9c";

        // Insert phone and verify code
        AccountVerify::create([
            "phone" => $request->phone,
            "verify_code" => $generateNumber
        ]);

        // Send message to whatsapp
        message("POST", $message, $phone_number, $message_type, $device_id);

        return response()->json([
            'success' => true,
            'message' => 'User has been created',
            'data'    => new UserResource($user),
            'token'   => JWTAuth::fromUser($user)
        ], 201);
    }

    public function verifyAccount(Request $request)
    {
        $account = AccountVerify::where('phone', $request->phone_number)->first();
        if ($account) {
            if ($request->verify_code == $account->verify_code) {
                User::where('phone', $account->phone)->update([
                    'phone_verify_status' => true
                ]);
                $response = [
                    'success' => true,
                    'message' => 'Verify Successfully',
                ];

                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Wrong verify code',
                ];

                return response()->json($response, 404);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Phone number not found',
            ];

            return response()->json($response, 404);
        }
    }
}
