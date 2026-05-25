<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
         $request->validated();
         $user=User::whereEmail($request->email)->first();
         if(!$user){
             return apiResponse(401, 'Invalid credentials');
         }

         if(!Hash::check($request->password,$user->password)){
               return apiResponse(401, 'Invalid credentials');
         }
          $token = $user->createToken('login')->plainTextToken;

          return apiResponse(200,'Login Success', ['user'=>new UserResource($user),'token'=>$token]);
    }
    public function logout(){
        $user=request()->user();

        $user->currentAccessToken()->delete();
         return apiResponse(200,'Logout Successfuly');
    }
}
