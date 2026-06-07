<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Auth\VerifyEmailService;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class VerifayEmailController extends Controller
{
    public function __construct(private VerifyEmailService $verifyEmailService) {}
    public function verifay(Request $request)
    {
        $request->validate(['token' => 'required']);
        try {

            $user = $this->verifyEmailService->verify($request->token, request()->user());
            return apiResponse(200, 'Email Verifaied Success', new UserResource($user));
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
    public function sendOtAgain()
    {
        $this->verifyEmailService->resend(request()->user());
        return apiResponse(200, 'Otp send Successfuly');
    }
}
