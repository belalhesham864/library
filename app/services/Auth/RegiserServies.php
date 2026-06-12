<?php

namespace App\services\Auth;

use App\Jobs\sandOtpRegister;
use App\Models\User;
use App\Utils\ImageManger;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegiserServies
{
    /**
     * Create a new class instance.
     */


    public function valdiation($request)
    {
       $validtor=Validator::make($request->all(),$request->rules());
       if($validtor->fails()){
       throw new Exception($validtor->errors());
       }
       return $validtor->validated();
    }
    public function store($request,$data){
    $data['image']=ImageManger::uploadImage($request,'uploads/users');
        $user=User::create($data);
        
        if(!$user){
             throw new Exception("User creation failed");
        }
        return $user;
    }
    
    public function sendOtp($user){
          sandOtpRegister::dispatch($user);
    }
    public function createToken($user)
    {
        $token = auth()->login($user);
       
        return $token;
    }
    public  function Register($request){
        try{

            $data= $this->valdiation($request);
            
            $user=$this->store($request,$data);
            $this->sendOtp($user);
            $token=  $this->createToken($user);
            return apiResponse(200,'Account Created Successfuly',['user'=>$user,'token'=>$token]);
            }catch(\Exception $e){
                  return apiResponse(422, $e->getMessage());
            }
    }
}
