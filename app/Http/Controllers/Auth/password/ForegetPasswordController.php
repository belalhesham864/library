<?php

namespace App\Http\Controllers\Auth\password;

use App\Http\Controllers\Controller;

use App\Services\Auth\ForgetPasswordService;
use Illuminate\Http\Request;

class ForegetPasswordController extends Controller
{
  
   
    public function __construct( private ForgetPasswordService $forgetPasswordService)
    {
       
    }
    public function forgetPassword(Request $request){
       $data=$request->validate(['email'=>'required|exists:users,email']);

          try {
            $this->forgetPasswordService->forgetPassword($data);
            return apiResponse(200, 'Otp Code Send Check Your Email');
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }


    public function checkOtp(Request $request){
       $data=$request->validate(['token' => 'required','email'=>'required']);
        try {
            $this->forgetPasswordService->checkOtp($data['email'],$data['token']);
            return apiResponse(200, 'Otp is success Reset your password');
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }}}
