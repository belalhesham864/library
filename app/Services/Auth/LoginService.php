<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\LoginRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function login($data){
        $user=User::whereEmail($data['email'])->first();
        if(!$user){
     throw new \Exception('Not Found',404);
        }

        $token=Auth::guard('api')->attempt($data);
        if(!$token){
        throw new \Exception( 'Unauthorized',401);
        }

    return ['user' => $user, 'token' => $token];
    
    }
}
