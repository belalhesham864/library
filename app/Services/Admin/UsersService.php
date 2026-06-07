<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UsersRepository;
use App\Utils\ImageManger;
use Exception;

class UsersService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UsersRepository $userRepo)
    {
        
    }
    public function index(){
    return    $this->userRepo->index();
            }
    public function show($id){
    return    $this->userRepo->show($id);
            }
        public function delete($id){
           $user= $this->userRepo->find($id);
           if(!$user){
            throw new Exception ('Not Found',404);
           }
           ImageManger::delete($user);
           return $this->userRepo->delete($user);
        }

}
