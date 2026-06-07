<?php

namespace App\Services\Auth;

use App\Notifications\SendOtpEmailNotification;
use Ichtrojan\Otp\Otp;

class VerifyEmailService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Otp $otp){}

    public function verify($token,$user){
         $check = $this->otp->validate($user->email, $token);

        if (!$check->status) {
            throw new \Exception('Otp is Invalid', 400);
        }

        $user->update(['email_verified_at' => now()]);

        return $user;
    }
    public function resend($user){
                $user->notify(new SendOtpEmailNotification);

    }
}
