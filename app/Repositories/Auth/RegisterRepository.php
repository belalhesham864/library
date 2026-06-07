<?php

namespace App\Repositories\Auth;

use App\Models\User;

class RegisterRepository
{
    /**
     * Create a new class instance.
     */
   public function register($data){
    return User::create($data);
   }
}
