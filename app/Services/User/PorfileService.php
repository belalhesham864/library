<?php

namespace App\Services\User;

use App\Repositories\User\PorfileRepository;
use App\Utils\ImageManger;

class PorfileService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private PorfileRepository $porfileRepo){}

    public function update($data,$user,$request){
            if ($request->hasFile('image')) {
            $data['image'] = ImageManger::update($request, $user, 'uploads/users');
        }
        return $this->porfileRepo->update($user,$data);
    }
    public function destroy($user){
        ImageManger::delete($user);
        return $this->porfileRepo->destroy($user);
    }

}
