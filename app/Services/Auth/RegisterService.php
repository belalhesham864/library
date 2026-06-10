<?php

namespace App\Services\Auth;

use App\Jobs\sandOtpRegister;
use App\Models\User;
use App\Repositories\Auth\RegisterRepository;
use App\Utils\ImageManger;

class RegisterService
{
    /**
     * Create a new class instance.
     */
    public function register($request,$data){
         $path=  ImageManger::uploadImage($request,'uploads/users');
          $data['image']=$path;
       $user=User::create($data);;
         if (!$user) {
                return throw new \Exception("Please try again",400);
            }
              sandOtpRegister::dispatch($user);
            $token =auth()->login($user);
                return ['user' => $user, 'token' => $token];

    }
}
