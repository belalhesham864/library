<?php

namespace App\Repositories\User;

class PorfileRepository
{
    /**
     * Create a new class instance.
     */
   public function update($user,$data){
     $user->update($data);
     return $user;
   }
   public function destroy($user){
            return $user->delete();

   }
}
