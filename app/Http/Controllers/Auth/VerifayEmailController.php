<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Notifications\SendOtpEmailNotification;
use App\Services\Auth\VerifyEmailService;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class VerifayEmailController extends Controller
{
    public $otp;
    public function __construct($otp)
    {
        $this->otp = new Otp();
    }
    public function verifay(Request $request)
    {
        $data = $request->validate(['token' => 'required']);
        try {
            $user = auth()->user();
            $check = $this->otp->validate($user->email, $data['token']);

            if (!$check->status) {
                throw new \Exception('Otp is Invalid', 400);
            }

            $user->update(['email_verified_at' => now()]);

            return apiResponse(200, 'Email Verifaied Success', new UserResource($user));
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
    public function sendOtAgain()
    {
        $user = auth()->user();
        $user->notify(new SendOtpEmailNotification);
        return apiResponse(200, 'Otp send Successfuly');
    }
}
