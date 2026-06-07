<?php

namespace App\Services\Auth;

use App\Jobs\sandOtpRegister;
use App\Repositories\Auth\RegisterRepository;
use App\Utils\ImageManger;

class RegisterService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private RegisterRepository $registerRepo){}
    public function register($request,$data){
         $path=  ImageManger::uploadImage($request,'uploads/users');
          $data['image']=$path;
       $user=$this->registerRepo->register($data);
         if (!$user) {
                return throw new \Exception("Please try again",400);
            }
              sandOtpRegister::dispatch($user);
            $token = $user->createToken('register')->plainTextToken;
                return ['user' => $user, 'token' => $token];

    }
}
