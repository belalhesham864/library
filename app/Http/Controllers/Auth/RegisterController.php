<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\SendOtpEmailNotification;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $request->validated();
            DB::beginTransaction();
            $user = User::create($request->except('image','password_confirmation'));
            if (!$user) {
                return apiResponse(400, 'Please try again');
            }
            if ($request->hasFile('image')) {
                $user->image = ImageManger::uploadImage($request);
                $user->save();
            }
     $user->notify(new SendOtpEmailNotification());
            $token = $user->createToken('register')->plainTextToken;
            DB::commit();
            return apiResponse(201, 'User Register Success', ['user' => new UserResource($user), 'token' => $token]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Register Error : ' . $e->getMessage());
            return apiResponse(500, 'Inrenal Server Error');
        }
    }
}
