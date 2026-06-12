<?php

namespace App\Http\Controllers\Auth\password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgetpasswordNotification;
use App\Services\Auth\ForgetPasswordService;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class ForegetPasswordController extends Controller
{

protected $otp;
    public function __construct($otp) {$this->otp=new Otp();}
    public function forgetPassword(Request $request)
    {
        $data = $request->validate(['email' => 'required|exists:users,email']);
             
        $user = User::whereEmail($data['email'])->first();
     
         $user->notify(new ForgetpasswordNotification());
              return apiResponse(200, 'Otp Code Send Check Your Email');
    }


    public function checkOtp(Request $request)
    {
        $data = $request->validate(['token' => 'required',  'email' => 'required|email|exists:users,email']);
        $check = $this->otp->validate($data['email'], $data['token']);
    
           if (!$check->status) {
          return apiResponse(400,'Otp is Invalid');
        }
            return apiResponse(200, 'Otp is success Reset your password');
      
    }
}
