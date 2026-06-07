<?php

namespace App\Services\Auth;

use App\Notifications\ForgetpasswordNotification;
use App\Repositories\Auth\LoginRepository;
use Ichtrojan\Otp\Otp;

class ForgetPasswordService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private LoginRepository $loginrepo,  private Otp $otp)
    {
        //
    }

    public function forgetPassword($data){
        $user=$this->loginrepo->findUser($data);
          if(!$user){
             throw new \Exception('User Not Found',404);
            
        }
         $user->notify(new ForgetpasswordNotification());
    }
     public function checkOtp($data, $token)
    {
           $user = $this->loginrepo->findUser($data['email']);

    if (!$user) {
        throw new \Exception('User Not Found', 404);
    }

      

        $check = $this->otp->validate($user->email, $token);

        if (!$check->status) {
            throw new \Exception('Otp is Invalid', 400);
        }

        return $user;
    }
}

