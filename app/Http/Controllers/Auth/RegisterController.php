<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Jobs\sandOtpRegister;
use App\Models\User;
use App\Notifications\SendOtpEmailNotification;
use App\services\Auth\RegiserServies;
use App\Services\Auth\RegisterService;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Override;

class RegisterController extends Controller
{
    
    public function register(RegisterRequest $request,RegiserServies $Register)
    {
       return $Register->Register($request);
    }
}
