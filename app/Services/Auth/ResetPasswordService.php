<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\LoginRepository;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{
    /**
     * Create a new class instance.
     */
   public function reset(string $email, string $password)
    {
        $user = User::whereEmail($email)->first();

        if (!$user) {
            throw new \Exception('User Not Found', 404);
        }

        $user->update(['password' => Hash::make($password)]);

        return $user;
    }
}
