<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\UpdateuserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\PorfileService;
use App\Utils\ImageManger;
use Illuminate\Http\Request;


class UserProfileController extends Controller
{
    public function __construct(private PorfileService $porfileService) {}
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
        $user = auth()->user();
        if ($request->hasFile('image')) {
            $data['image'] = ImageManger::update($request, $user, 'uploads/users');
        }
        $user->update($data);
        return apiResponse(200, 'Updated Success', new UserResource($user));
    }

    public function destroy()
    {
        $user = auth()->user();
        ImageManger::delete($user);
        $user->delete();
        return apiResponse(200, 'Deleted Success');
    }
}
