<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Notifications\ForgetpasswordNotification;
use App\Repositories\Auth\LoginRepository;
use Ichtrojan\Otp\Otp;

class ForgetPasswordService
{
    /**
     * Create a new class instance.
     */
    public function __construct(  private Otp $otp)
    {
        //
    }

    public function forgetPassword($data){
        $user=User::whereEmail($data['email'])->first();
          if(!$user){
             throw new \Exception('User Not Found',404);
            
        }
         $user->notify(new ForgetpasswordNotification());
    }
     public function checkOtp($data, $token)
    {
           $user = User::whereEmail($data)->first();

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

