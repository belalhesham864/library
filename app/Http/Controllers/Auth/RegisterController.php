<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Jobs\sandOtpRegister;
use App\Models\User;
use App\Notifications\SendOtpEmailNotification;
use App\Services\Auth\RegisterService;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Override;

class RegisterController extends Controller
{

    public function __construct(private RegisterService $registerSer) {}
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $data = $this->registerSer->register($request, $data);
            return apiResponse(201, 'User Register Success', ['user' => new UserResource($data['user']), 'token' => $data['token']]);
        } catch (\Exception $e) {

            Log::error('Register Error : ' . $e->getMessage());
            return apiResponse($e->getCode(), $e->getMessage());
        }
    }
}
