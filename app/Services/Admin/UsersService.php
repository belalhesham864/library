<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Repositories\Admin\UsersRepository;
use App\Utils\ImageManger;
use Exception;

class UsersService
{
        /**
         * Create a new class instance.
         */
        public function index()
        {
                return  User::select('id', 'name', 'email', 'created_at')
                        ->paginate(10);
        }
        public function show($id)
        {
                return  User::select('id', 'name', 'email', 'created_at')->find($id);
        }
        public function delete($id)
        {
                $user =  User::find($id);

                if (!$user) {
                        throw new Exception('Not Found', 404);
                }
                ImageManger::delete($user);
                return $user->delete();
        }
}
