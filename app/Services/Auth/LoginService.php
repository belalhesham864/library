<?php

namespace App\Services\Auth;

use App\Repositories\Auth\LoginRepository;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private LoginRepository  $loginRepo){}
    public function login($data){
        $user=$this->loginRepo->findUser($data);
        if(!$user){
     throw new \Exception('Not Found',404);
        }
           if(!Hash::check($data['password'],$user->password)){
          throw new \Exception( 'Invalid credentials',401);
         }
    $token = $user->createToken('login')->plainTextToken;
    return ['user' => $user, 'token' => $token];
    }
}
