<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->model->paginate();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateUserRequest $request)
    {
        $data = $request->validated();

        //Encrypt password
        $data['password'] = bcrypt($data['password']);

        $user = $this->model->create($data);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $identify)
    {
        $user = $this->model->where('uuid', $identify)->firstOrFail();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateUserRequest $request, string $identify)
    {
        $user = $this->model->where('uuid', $identify)->firstOrFail();

        $data = $request->validated();

        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'updated' => 'success'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $identify)
    {
        $user = $this->model->where('uuid', $identify)->firstOrFail();

        $user->delete();

        return response()->json([
            'deleted' => 'success'
        ], 201);
    }
}
