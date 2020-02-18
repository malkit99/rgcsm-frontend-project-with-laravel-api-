<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;



class AuthController extends Controller
{
    public function login(UserLoginRequest $request , LoginAction $loginAction){


            $passsportRequest = $loginAction->run($request->all());
            $tokenContent  = $passsportRequest['content'];
            if(!empty($tokenContent['access_token'])){
                return $passsportRequest['response'];
            }

            return response()->json([
                'message' => 'UnAuthenticated'
            ],400);

    }

    public function register(UserRegisterRequest $request , RegisterAction $registerAction){
        $user = $registerAction->run($request->all());

        if(!$user){
            return response()->json(['success' => false ,'message' => ' Registration Failed' ], 400);
        }

        return response()->json(['success' => true ,'message' => ' Registration Succeeded' ], 200);

    }
}
