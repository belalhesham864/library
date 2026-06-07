<?php

namespace App\Repositories\Auth;

use App\Models\User;

class LoginRepository
{
    public function findUser($data){
        return User::whereEmail($data['email'])->first();
    }
}
