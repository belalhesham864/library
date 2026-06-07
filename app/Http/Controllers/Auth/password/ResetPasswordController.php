<?php

namespace App\Http\Controllers\Auth\password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function __construct(private ResetPasswordService $resetPasswordService) {}
public function reset(Request $request){
        $request->validate(['password'=>'required|confirmed|min:8','email'=>'required|exists:users,email']);
  try {
            $this->resetPasswordService->reset($request->email, $request->password);
            return apiResponse(200, 'Password Changed Successfully');
        } catch (\Exception $e) {
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
}
