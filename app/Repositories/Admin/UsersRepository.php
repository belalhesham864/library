<?php

namespace App\Repositories\Admin;

use App\Models\User;

class UsersRepository
{
    /**
     * Create a new class instance.
     */
   public function index(){
            return  User::select('id', 'name', 'email', 'created_at')
            ->paginate(10);
        }
        public function show($id){
             return  User::select('id', 'name', 'email', 'created_at')->find($id);
        }
        public function find($id){
             return  User::find($id);
        }
        public function delete($user){
             return $user->delete();
        }
        

}
