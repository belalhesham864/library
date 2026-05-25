<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Notifications\SendOtpEmailNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Override;

class VerifayEmailController extends Controller
{
    public $otp;
    public function __construct()
    {
        $this->otp=new Otp();
      
    }
    public function verifay(Request $request){
     $request->validate(['token'=>'required']);
    $user=request()->user();
  
    $token=$request->token;
    $check=$this->otp->validate($user->email,$token);
    if($check->status==false){
        return apiResponse(400,'Otp is Invailed');
    }
    $user->update(['email_verified_at'=>now()]);
    return apiResponse(200,'Email Verifaied Success',new UserResource($user));
    }
    public function sendOtAgain(){
         $user=request()->user();
         $user->notify(new SendOtpEmailNotification);
        return apiResponse(200,'Otp send Successfuly');
    }
}
