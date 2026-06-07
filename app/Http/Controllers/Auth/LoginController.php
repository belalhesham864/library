<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(private LoginService $loginService) {}

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        try {

            $result = $this->loginService->login($data);
            return apiResponse(200, 'Login Success', ['user' => new UserResource($result['user']), 'token' => $result['token']]);
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return apiResponse(200, 'Logout Successfuly');
    }
}
