<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPermissionUserRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionUserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function permissionsUser($identify)
    {
        $user = $this->user
                        ->where('uuid', $identify)
                        ->with('permissions')
                        ->firstOrFail();

        return PermissionResource::collection($user->permissions);
    }

    public function addPermissionsUser(AddPermissionUserRequest $request)
    {
        if(Gate::denies('add_permissions_user')){
            abort(403, 'Not Authorized');
        }

        $user = $this->user->where('uuid', $request->user_id)->firstOrFail();

        //Vinculando array de permissoes pelo attach
        $user->permissions()->attach($request->permissions);

        return response()->json(['message' => 'success']);
    }

    public function removePermissionsUser(Request $request)
    {
        $user = $this->user->where('uuid', $request->user_id)->firstOrFail();

        //removendo array de permissoes pelo detach
        if($request->permissions){
            $user->permissions()->detach($request->permissions);
        }

        return response()->json(['message' => 'success']);
    }

    public function userHasPermission(Request $request, $permission)
    {
        $user = $request->user();

        if(!$user->isSuperAdmin() && !$user->hasPermission($permission)){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['message' => 'success']);
    }
}
