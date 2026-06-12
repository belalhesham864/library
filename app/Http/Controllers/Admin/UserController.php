<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Admin\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UsersService $userService) {}

    public function index()
    {
        $users = User::select('id', 'name', 'email', 'created_at')
                        ->paginate(10);

        if ($users->isEmpty()) {
            return apiResponse(404, 'No Users Found');
        }

        return apiResponse(200, 'All Users', (new UserCollection($users))->response()->getData());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */    public function show($id)
    {
        $user = User::select('id', 'name', 'email', 'created_at')->find($id);
        if (!$user) {
            return apiResponse(404, 'User Not Found');
        }

        return apiResponse(200, 'User Details', new UserResource($user));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return apiResponse(404, 'User Not Found');
        }
        if ($user->image && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }
        $user->delete();
        return apiResponse(200, 'Deleted Success');
    }
}
