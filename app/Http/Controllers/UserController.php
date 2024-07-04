<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  public function __construct(){
    $this->middleware('auth:api');
  }
   
  public function getAll(){
    $users = User::all();
    return response()->json($users);
  }

  public function findId($id){
    $user = User::find($id);
    if(!empty($user)){
      return response()->json($user);
    }else{
      return response()->json([
        "message" => "User not found"
      ], 404);
    }
  }

  public function save(Request $request){
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->email_verified_at = $request->email_verified_at;
    $user->password = $request->password;
    $user->save();
    return response()->json([
      "message" => "User Added"
    ], 201);
  }

  public function update(Request $request, $id){
    if(User::where('id', $id)->exists()){
      $user = User::find($id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = $request->password;
      $user->updated_at = now();
      $user->save();
      return response()->json([
        "message" => "User Updated"
      ], 200);
    }else{
      return response()->json([
        "message" => "User not Found"
      ], 404);
    }
  }

  public function delete($id){
    if(User::where('id', $id)->exists()){
      $user = User::find($id);       
      $user->delete();
      return response()->json([
        "message" => "User Deleted"
      ], 200);
    }else{
      return response()->json([
        "message" => "User not Found"
      ], 404);
    }
  }
}
