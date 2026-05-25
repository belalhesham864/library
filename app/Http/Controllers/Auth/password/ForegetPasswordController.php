<?php

namespace App\Http\Controllers\Auth\password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgetpasswordNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Override;

class ForegetPasswordController extends Controller
{
    public $otp;
   
    public function __construct()
    {
         $this->otp=new Otp();
    }
    public function forgetPassword(Request $request){
        $request->validate(['email'=>'required|exists:users,email']);
        $user=User::whereEmail($request->email)->first();
        if(!$user){
            return apiResponse(404,'User Not Found');
        }
        $user->notify(new ForgetpasswordNotification());
        return apiResponse(200,'Otp Code Send Check Your Email');
    }


    public function checkOtp(Request $request){
        $request->validate(['token'=>"required"]);
        $token=$request->token;
          $user=User::whereEmail($request->email)->first();
       $check=$this->otp->validate($user->email,$token);
       if($check->status==false){
         return apiResponse(400,'Otp is Invailed');
       }
       return apiResponse(200,'Otp is success Reset your password');
    }
}
