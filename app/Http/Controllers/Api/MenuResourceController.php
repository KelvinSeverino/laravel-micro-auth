<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource as ResourcesMenuResource;
use App\Models\MenuResource;
use Illuminate\Http\Request;

class MenuResourceController extends Controller
{
    protected $model;

    public function __construct(MenuResource $menuResource)
    {
        $this->model = $menuResource;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = $this->model->with('permissions')->get();

        return ResourcesMenuResource::collection($resources);
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
     */
    public function show(string $id)
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
        //
    }
}
