<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\LoginService;
use App\services\Auth\LoginServies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Override;

class LoginController extends Controller
{


    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $token = Auth::guard('api')->attempt($data);
        if (!$token) {
            return apiResponse(401, 'Unauthorized');
        }
        return apiResponse(200, 'Login Success', ['user' => auth()->user(), 'token' => $token]);
    }
    public function logout()
    {
        auth()->logout();
        return apiResponse(200, 'Logout Successfuly');
    }

   
}
