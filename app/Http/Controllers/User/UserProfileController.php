<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\users\UpdateuserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\PorfileService;


class UserProfileController extends Controller
{
    public function __construct(private PorfileService $porfileService){}
     public function show()
    {
        $user = request()->user();
        if (!$user) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', new UserResource($user));
    }
    
        public function update(UpdateuserRequest $request)
    {
$data=$request->validated();

      $user=$this->porfileService->update($data,request()->user(),$request);
        return apiResponse(200, 'Updated Success', new UserResource($user));

    }
    
        public function destroy()
    {
        $this->porfileService->destroy(request()->user());
        return apiResponse(200, 'Deleted Success');
    }
}
