<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    public function __construct(){
      $this->middleware('auth:api');
    }

    public function getAll(){
      $roles = Role::all();
      return response()->json($roles);
    }

    public function findId($id){
      $role = Role::find($id);
      if(!empty($role)){
        return response()->json($role);
      }else{
        return response()->json([
          "message" => "Role not found"
        ], 404);
      }
    }

    public function save(Request $request){
      $role = new Role;
      $role->nome = $request->nome;
      $role->save();
      return response()->json([
        "message" => "Role Added"
      ], 201);
    }

    public function update(Request $request, $id){
      if(Role::where('id', $id)->exists()){
        $role = Role::find($id);
        $role->nome = $request->nome;
        $role->updated_at = now();
        $role->save();
        return response()->json([
          "message" => "Role Updated"
        ], 200);
      }else{
        return response()->json([
          "message" => "Role not Found"
        ], 404);
      }
    }

    public function delete($id){
      if(Role::where('id', $id)->exists()){
        $role = Role::find($id);       
        $role->delete();
        return response()->json([
          "message" => "Role Deleted"
        ], 200);
      }else{
        return response()->json([
          "message" => "Role not Found"
        ], 404);
      }
    }
    
}
