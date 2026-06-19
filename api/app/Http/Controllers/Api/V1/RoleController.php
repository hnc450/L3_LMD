<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $roles = Role::all();

       return response()->json([
          'message' =>'All roles',
          'roles' => $roles
       ])->setStatusCode(200);
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
    public function show(int $id)
    {
       try
       {
          $role = Role::findOrFail($id);

           return response()->json([
              'role-name' => $role->name,
              'role' => $role
          ])->setStatusCode(200);

       }

       catch(ModelNotFoundException $e)
       {
        return response()->json([
           'role-id' => $id,
           'message' => 'role inexistant'
          ])->setStatusCode(404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    public function delete(int $id){
      try
       {
          $role = $role = Role::withTrashed()->findOrFail($id);
          $name = $role->name;
          $role->forceDelete();

           return response()->json([
              'message' => 'Role -> '.$name.' supprimé definitivement',
          ])->setStatusCode(200);

       }

       catch(ModelNotFoundException $e)
       {
        return response()->json([
           'message' => 'role inexistant'
          ])->setStatusCode(404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function trash(int $id)
    {
        try
       {
          $role = Role::findOrFail($id);
          $name = $role->name;
          $role->delete();

           return response()->json([
              'message' => 'Role -> '.$name.' supprimé avec success',
          ])->setStatusCode(200);

       }

       catch(ModelNotFoundException $e)
       {
        return response()->json([
           'message' => 'role inexistant'
          ])->setStatusCode(404);
        }
    }
}
