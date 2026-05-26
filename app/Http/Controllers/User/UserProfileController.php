<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\users\UserRequest;
use App\Http\Requests\users\UpdateuserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Utils\ImageManger;

use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{
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

        $data = $request->validated();

        $user = request()->user();
        if (!$user) {
            return apiResponse(404, 'Not Found');
        }
        if ($request->hasFile('image')) {
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $data['image'] = ImageManger::uploadImage($request);
        }
        $user->update($data);
        return apiResponse(200, 'Updated Success', new UserResource($user));
    }
        public function destroy()
    {
        $user = request()->user();
        if (!$user) {
            return apiResponse(404, 'Not Found');
        }
        if ($user->image && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }
        $user->delete();
        return apiResponse(200, 'Deleted Success');
    }
}
