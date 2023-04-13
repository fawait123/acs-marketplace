<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('username',$request->username)->orWhere('email',$request->username)->first();

            if(!$user){
                return response()->json([
                    'status'=>404,
                    'message'=>'The credentials dosnt match to our record',
                    'data'=>[]
                ],404);
            }

            if(!Hash::check($request->password,$user->password)){
                return response()->json([
                    'status'=>404,
                    'message'=>'The credentials dosnt match to our record',
                    'data'=>[]
                ],404);
            }

            if($user->is_active ==0){
                return response()->json([
                    'status'=>400,
                    'message'=>'The Account is non active',
                    'data'=>[]
                ],400);
            }

            $token = $user->createToken('CarShop API Token')->accessToken;

            return response()->json([
                'status'=>200,
                'message'=>'Login Success',
                'data'=>[
                    'token'=>$token
                ]
            ],200);
        } catch (Exception $error) {
            return response()->json([
                'status'=>500,
                'message'=>$error->getMessage()
            ],500);
        }
    }

    public function unauthenticate()
    {
        return response()->json([
            'status'=>401,
            'message'=>'Anauthorized',
            'data'=>[]
        ],401);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status'=>200,
            'message'=>'profile',
            'data'=>[
                'results'=>$request->user()
            ]
        ],200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status'=>200,
            'message'=>'logout success',
            'data'=>[]
        ],200);
    }
}
