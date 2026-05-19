<?php

namespace App\Http\Controllers;

use App\Http\Requests\users\UserRequest;
use App\Http\Requests\users\UpdateuserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id','name','email','created_at')->paginate(10);
        if ($users->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }

        return apiResponse(200, 'Success', (new UserCollection($users))->response()->getData());
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
    public function store(UserRequest $request)
    {
       $data= $request->validated();
  $data['email_verified_at']=now();

        $user = User::create($data);
        if (!$user) {
            return apiResponse(400, 'Try Again');
        }
        return apiResponse(201, 'Created Success', new UserResource($user));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
          $user = User::find($id);

    if (!$user) {
        return apiResponse(404, 'Not Found');
    }

    return apiResponse(200, 'Success', new UserResource($user));
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
    public function update(UpdateuserRequest $request, string $id)
    {

        $data=$request->validated();

        $user = User::find($id);
        if (!$user) {
            return apiResponse(404, 'Not Found');
        }
        $user->update($data);
        return apiResponse(200, 'Updated Success', new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return apiResponse(404, 'Not Found');
        }
        $user->delete();
        return apiResponse(200, 'Deleted Success');
    }
}
