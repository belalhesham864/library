<?php

namespace App\Http\Controllers\Auth\password;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function reset(Request $request){
        $request->validate(['password'=>'required|confirmed|min:8','email'=>'required|exists:users,email']);
        $user=User::whereEmail($request->email);
        if(!$user){
            return apiResponse(404,'User Not Found');
        }
        $user->update(['password'=>Hash::make($request->password)]);
        return apiResponse(200,'Password Changed Successfuly');
    }
}
