<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
  public function getAll(){
    $statuss = Status::all();
    return response()->json($statuss);
  }

  public function findId($id){
    $status = Status::find($id);
    if(!empty($status)){
      return response()->json($status);
    }else{
      return response()->json([
        "message" => "Status not found"
      ], 404);
    }
  }

  public function save(Request $request){
    $status = new Status;
    $status->nome = $request->nome;
    $status->save();
    return response()->json([
      "message" => "Status Added"
    ], 201);
  }

  public function update(Request $request, $id){
    if(Status::where('id', $id)->exists()){
      $status = Status::find($id);
      $status->nome = $request->nome;
      $status->updated_at = now();
      $status->save();
      return response()->json([
        "message" => "Status Updated"
      ], 200);
    }else{
      return response()->json([
        "message" => "Status not Found"
      ], 404);
    }
  }

  public function delete($id){
    if(Status::where('id', $id)->exists()){
      $status = Status::find($id);       
      $status->delete();
      return response()->json([
        "message" => "Status Deleted"
      ], 200);
    }else{
      return response()->json([
        "message" => "Status not Found"
      ], 404);
    }
  }
}
