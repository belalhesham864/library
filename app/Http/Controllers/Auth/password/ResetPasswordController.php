<?php

namespace App\Http\Controllers\Auth\password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function reset(Request $request)
    {
       $data= $request->validate(['password' => 'required|confirmed|min:8', 'email' => 'required|exists:users,email']);
        $user = User::where('email', $data['email'])->first();
            $user->update(['password' => Hash::make($data['password'])]);
            return apiResponse(200, 'Password Changed Successfully');
     
    }
}
